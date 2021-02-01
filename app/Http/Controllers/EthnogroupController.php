<?php

namespace App\Http\Controllers;

use App\Models\AuditEvent;
use App\Models\Ethnogroup;
use App\Models\Psgc;
use Illuminate\Http\Request;

class EthnogroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ethnogroup::orderBy('id', 'DESC')->get();
        $regions = Psgc::where('level', 'Reg')->get();

        return view('ethnogroups.index', compact('data', 'regions'));
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
        $request->validateWithBag('ethnoGroup', [
            'region' => 'required',
            'ipgroup' => 'required',
        ]);

        $input = $request->all();

        Ethnogroup::updateOrCreate(["id" => $request->id], $input);

        if(isset($request->id)){
            AuditEvent::insert('Update ethnogroup');
        }else{
            AuditEvent::insert('Create ethnogroup');
        }

        $notification = array(
            'message' => 'Ethnolinguistic Group updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ethnogroup  $ethnogroup
     * @return \Illuminate\Http\Response
     */
    public function show(Ethnogroup $ethnogroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ethnogroup  $ethnogroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Ethnogroup $ethnogroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ethnogroup  $ethnogroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ethnogroup $ethnogroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ethnogroup  $ethnogroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ethnogroup::find($id)->delete();

        $notification = array(
            'message' => 'Ethnolinguistic Group removed successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
