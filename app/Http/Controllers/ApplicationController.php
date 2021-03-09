<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Grant;
use App\Models\Psgc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function applicationForm($id)
    {
        $data = Application::with('applicant')
            ->with('education')
            ->with('sibling')
            ->where('id', $id)
            ->first();
        return view('applications.applicationForm', compact('data'));
    }

    public function showAllApplication()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }

        $regions = Psgc::where('code', Auth::user()->region)->get();
        $data = Application::with('applicant.psgcBrgy')
            ->with('grant')
            ->where('status', '')
            ->orWhere('status', 'New')
            ->orWhere('status', 'On Process')
            ->orderBy('id', 'DESC')
            ->get();

        return view('applications.showAllApplication', compact('data', 'regions', 'locationId'));
    }

    public function showAllApproved()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }

        $regions = Psgc::where('code', Auth::user()->region)->get();
        $data = Application::with('applicant.psgcBrgy')
            ->where('status', 'Approved')
            ->orderBy('id', 'DESC')
            ->get();

        return view('applications.showAllApproved', compact('data', 'regions', 'locationId'));
    }

    public function showApproved($id)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }

        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', 'Approved')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();

        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces', 'locationId'));
    }

    public function showTerminated($id)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }

        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', '!=', 'Approved')
            ->where('status', '!=', 'On Process')
            ->where('status', '!=', 'Graduated')
            ->whereNotNull('status')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces', 'locationId'));
    }

    public function showOnProcess($id)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', 'On Process')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces', 'locationId'));
    }

    public function showAllNew($id)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }
        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->where('status', 'New')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces', 'locationId'));
    }

    public function showGraduated($id)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }

        $data = Application::with('applicant.psgcBrgy')->with('employment')
            ->where('grant_id', $id)
            ->where('status', 'Graduated')
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces', 'locationId'));
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
        $request->validateWithBag('application', [
            'id',
            'grant_id' => 'required',
            'user_id' => 'required',
            'type' => 'required',
            'level' => 'required',
            'school' => 'required',
            'course' => 'required',
            'contribution' => 'required',
            'plans' => 'required',
            'status' => 'nullable',
            'remarks' => 'nullable',
        ]);

        $grantid = [
            "id" => $request->id,
        ];
        $grantInformation = $request->all();

        Application::updateOrCreate($grantid, $grantInformation);

        $notification = array(
            'message' => 'Profile updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $locationId = '';
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $locationId = Str::substr(Auth::user()->region, 0, 2);
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
        }

        $data = Application::with('applicant.psgcBrgy')
            ->where('grant_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        $grant = Grant::with('psgCode')->where('id', $id)->first();
        $regionId = Str::substr($grant->region, 0, 2);
        $provinces = Psgc::where([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Prov']])
            ->orwhere([[\DB::raw('substr(code, 1, 2)'), '=', $regionId], ['level', 'Dist']])
            ->get();

        return view('applications.show', compact('data', 'grant', 'provinces', 'locationId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::find($id);

        return response()->json(['application' => $application]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Application::find($id)->delete();

        $notification = array(
            'message' => 'Record deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
