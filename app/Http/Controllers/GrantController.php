<?php

namespace App\Http\Controllers;

use App\Models\AuditEvent;
use App\Models\Grant;
use App\Models\Psgc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = Grant::orderBy('id', 'DESC')->get();
            $regions = Psgc::where('level', 'Reg')->get();
        } else {
            $data = Grant::where('region', Auth::user()->region)->orderBy('id', 'DESC')->get();
            $regions = Psgc::where('code', Auth::user()->region)->get();
        }

        return view('grants.index', compact('data', 'regions'));
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
        $request->validateWithBag('grant', [
            'id',
            'region' => 'required',
            'acadYr' => 'required',
            'applicationOpen' => 'required',
            'applicationClosed' => 'required'
        ]);

        $grantid = [
            "id" => $request->id,
        ];
        $grantInformation = $request->all();

        Grant::updateOrCreate($grantid, $grantInformation);

        $notification = array(
            'message' => 'Profile updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function show(Grant $grant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grants = Grant::find($id);

        return response()->json(['grants' => $grants]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grant $grant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grant  $grant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grant = Grant::find($id);

        $grant->delete();

        $notification = array(
            'message' => 'Scholarship/Grant deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
