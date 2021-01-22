<?php

namespace App\Http\Controllers;

use App\Models\AdminCost;
use App\Models\Application;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function formB()
    {
        $data = Application::with('applicant')->get();
        return view('reports.formB', compact('data'));
    }

    public function formC()
    {
        $data = Application::with('applicant')->get();
        return view('reports.formC', compact('data'));
    }

    public function formE()
    {
        $data = AdminCost::all();
        return view('reports.formE', compact('data'));
    }

    public function formF()
    {
        $data = AdminCost::all();
        return view('reports.formF', compact('data'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
