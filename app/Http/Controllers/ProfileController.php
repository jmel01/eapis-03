<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Profile;
use App\Models\Psgc;
use App\Models\Siblings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
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
        if($request->hasFile('profilePicture')){
            return Profile::updatePicture($request);
        }

        if(isset($request->forProfilePicture) && $request->forProfilePicture == 'picture'){
            return back();
        }

        $request->validateWithBag('profile', [
            'user_id',
            'lastName' => 'required',
            'firstName' => 'required',
            'middleName' => 'required',
            'birthdate' => 'required',
            'placeOfBirth' => 'required',
            'gender' => 'required',
            'civilStatus' => 'required',
            'ethnoGroup' => 'required',
            'contactNumber' => 'required',
            'email',
            'address' => 'required',
            'region' => 'required',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'psgCode',
            'fatherLiving' => 'required',
            'fatherName' => 'required',
            'fatherAddress' => 'required',
            'fatherOccupation' => 'required',
            'fatherOffice' => 'required',
            'fatherEducation' => 'required',
            'fatherEthnoGroup' => 'required',
            'fatherIncome' => 'required',
            'motherLiving' => 'required',
            'motherName' => 'required',
            'motherAddress' => 'required',
            'motherOccupation' => 'required',
            'motherOffice' => 'required',
            'motherEducation' => 'required',
            'motherEthnoGroup' => 'required',
            'motherIncome' => 'required',
        ]);

        $input = $request->all();
        $input['psgCode'] = $request->barangay;

        Profile::updateOrCreate(["user_id" => $request->id], $input);

        Education::insert($request);
        Siblings::insert($request);

        $notification = array(
            'message' => 'Profile updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $regions = Psgc::where('level', 'Reg')->get();
        } else {
            if (Auth::user()->region) {
                $regions = Psgc::where('code', Auth::user()->region)->get();
            } else {
                $regions = Psgc::where('level', 'Reg')->get();
            }
        }


        $userProfile = Profile::where('user_id', $id)->first();
        $psgCode = $userProfile->psgCode ?? '';
        //$psgCode = Auth::user()->profile->psgCode;

        $region = Psgc::where('code', Str::substr($psgCode, 0, 2) . "0000000")->first();
        $province = Psgc::where('code', Str::substr($psgCode, 0, 4) . "00000")->first();
        $city = Psgc::where('code', Str::substr($psgCode, 0, 6) . "000")->first();
        $barangay = Psgc::where('code', $psgCode)->first();

        return view('profiles.show', compact('userProfile', 'regions', 'region', 'province', 'city', 'barangay'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userProfile = Profile::where('user_id', $id)->first();

        return response()->json($userProfile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
