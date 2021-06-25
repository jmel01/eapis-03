<?php

namespace App\GlobalClass;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Datatables{

    public static $queryResult, $searchRequest;
    public static $actionName, $addAction;
    public static $actionRequest = array();

    public static $draw, $start, $totalRecords, $totalRecordwithFilter, $data, $rowperpage, $orderByQuery;
    public static $columnIndex, $columnName, $columnSortOrder, $searchValue, $searchArray, $searchQuery, $columnSortable;

    public static function request(Request $request){
        self::$draw = $request->draw;
        self::$start = $request->start;

        self::$rowperpage = $request->length; // Rows display per page
        self::$columnIndex = $request->order[0]['column']; // Column index
        self::$columnName = $request->columns[self::$columnIndex]['data']; // Column name
        self::$columnSortable = $request->columns[self::$columnIndex]['orderable']; // Column name
        self::$columnSortOrder = $request->order[0]['dir']; // asc or desc
        self::$searchValue = $request->search['value'] ?? ''; // Search value

        self::$searchArray = array();
        self::$searchQuery = " ";

        return new static;
    }

    public static function of($query){
        static::$queryResult = $query;
        return new static;
    }

    public static function orderBy($orderByQuery){
        static::$orderByQuery = $orderByQuery;
        return new static;
    }

    public static function addAction($actionName, $addAction){
        self::$actionName = $actionName;
        self::$addAction = $addAction;

        self::$actionRequest += array($actionName => $addAction);

        return new static;
    }

    public static function searchable($search){
        self::$searchRequest = $search;
        return new static;
    }

    public static function search(){
        $searchValue = self::$searchValue;

        if($searchValue != ''){
            $response = self::searchableColumn();
            $whereQuery = " AND (";

            for($start = 0;  $start < count($response); $start++){
                if(count($response) - 1 == $start){
                    $whereQuery .= $response[$start]." LIKE '%".$searchValue."%')";
                }else{
                    $whereQuery .= $response[$start]." LIKE '%".$searchValue."%' or ";
                }
            }

            self::$searchQuery = $whereQuery;
        }
    }

    public static function searchableColumn(){
        $query = self::$queryResult." ";

        if(isset(self::$searchRequest)){
            return self::$searchRequest;
        }

        $stmt = DB::select(DB::raw($query));

        $queryArray = array_map(function ($value) {
            return (array)$value;
        }, $stmt);

        $columnNames = array_keys($queryArray[0]);

        if (($key = array_search('id', $columnNames)) !== false) {
            unset($columnNames[$key]);
        }

        return array_values($columnNames);
    }

    public static function recordCount(){
        self::$totalRecords =  self::count(static::$queryResult);
    }

    public static function recordWithFilterCount(){
        $txt = self::$queryResult.' '.self::$searchQuery;

        $stmt =  self::count($txt);
        self::$totalRecordwithFilter =  $stmt;
    }

    public static function count($query){
        $txt = $query;
        $count = 0;

        $records = DB::select(DB::raw($txt));

        foreach($records as $row){
            $count++;
        }

        return $count;
    }

    public static function returnData(){
        $fetchQuery = self::$queryResult.' '.self::$searchQuery
        ." ORDER BY ".self::$columnName
        ." ".self::$columnSortOrder
        ." LIMIT ".self::$rowperpage." OFFSET ".self::$start."";

        if(isset(self::$orderByQuery)){
            $fetchQuery = self::$queryResult.' '.self::$searchQuery
            .' '.self::$orderByQuery.' '
            ." LIMIT ".self::$rowperpage." OFFSET ".self::$start."";
        }

        return DB::select(DB::raw($fetchQuery));
    }

    public static function record(){
        $empRecords = self::returnData();

        $data = array();

        $pattern = '/{{(.*?)[\|\|.*?]?}}/';

        foreach($empRecords as $value) {
            if(isset(self::$actionRequest)){
                $actionToAdd = array();
                foreach(self::$actionRequest as $actionName => $actionValue){
                    // $replace = preg_replace_callback($pattern, function($match) use ($value){
                    //     $match = explode('||',$match[1]);
                    //     foreach($match as $toReplace){
                    //         return $value->$toReplace;
                    //     }
                    // }, $actionValue);
                    $actionToAdd += array($actionName => self::createClosure($value, $actionValue));
                }

                $data[] = (object) array_merge((array) $value, $actionToAdd);
            }else{
                $data[] = $value;
            }
        }

        self::$data = $data;
    }

    public static function createClosure($data, $actionValue){
        $addAction = $actionValue;

        $ac = function ($data) use ($addAction){
            return $addAction($data);
        };

        return $ac($data);
    }

    public static function make(){
        self::search();
        self::recordCount();
        self::recordWithFilterCount();
        self::record();

        $response = array(
            "draw" => self::$draw,
            "iTotalRecords" => self::$totalRecords,
            "iTotalDisplayRecords" => self::$totalRecordwithFilter,
            "aaData" => self::$data,
        );

        return $response;
    }
}
