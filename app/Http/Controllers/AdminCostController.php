<?php

namespace App\Http\Controllers;

use App\Models\AdminCost;
use App\Models\Grant;
use App\Models\Psgc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCostController extends Controller
{
    public function showAdminCost($id)
    {
        $data = AdminCost::with('provname')
            ->where('grant_id', $id)
            ->whereNull('user_id')
            ->get();
        $grant = Grant::where('id', $id)->first();

        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('costs.showAdminCost', compact('data', 'grant', 'provinces'));
    }

    public function showPaymentToGrantee($id)
    {
        $data = AdminCost::with('provname')
            ->where('grant_id', $id)
            ->whereNotNull('user_id')
            ->get();
        $grant = Grant::where('id', $id)->first();

        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('costs.showPaymentToGrantee', compact('data', 'grant', 'provinces'));
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
        $request->validateWithBag('cost', [
            'id',
            'grant_id' => 'required',
            'user_id',
            'dateRcvd' => 'required',
            'payee' => 'required',
            'particulars',
            'amount' => 'required',
            'checkNo',
            'province' => 'required',

        ]);

        $input = $request->all();

        AdminCost::updateOrCreate(["id" => $request->id], $input);

        $notification = array(
            'message' => 'Admin cost updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminCost  $adminCost
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = AdminCost::with('provname')->where('grant_id', $id)->get();
        $grant = Grant::where('id', $id)->first();

        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('costs.show', compact('data', 'grant', 'provinces'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminCost  $adminCost
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cost = AdminCost::find($id);

        return response()->json(['cost' => $cost]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminCost  $adminCost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminCost $adminCost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminCost  $adminCost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adminCost = AdminCost::find($id);

        $adminCost->delete();

        $notification = array(
            'message' => 'Record deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
