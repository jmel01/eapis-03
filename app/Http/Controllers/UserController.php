<?php

namespace App\Http\Controllers;

use App\ChartArray\Registered;
use App\Http\Controllers\Controller;
use App\Models\AdminCost;
use App\Models\Application;
use App\Models\Calendar;
use App\Models\Grant;
use App\Models\Profile;
use App\Models\Psgc;
use App\Models\User;
use DataTables;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function newUser(Request $request)
    {
        $data = User::with('profile')
            ->where(function ($query) {
                $query->role(['Applicant'])
                    ->ordoesntHave('roles');
            })
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')->from('applications');
            })
            ->orderBy('id', 'DESC')
            ->get();

        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $regions = Psgc::where('level', 'Reg')->get();
            $grants = Grant::where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $regionId = Auth::user()->region;
            $data =  $data->whereIn('region', [$regionId, '']);

            $regions = Psgc::where('code', Auth::user()->region)->get();
            $grants = Grant::where('region', Auth::user()->region)
                ->where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $regionId = Auth::user()->region;
            $data =  $data->whereIn('region', [$regionId, '']);

            $regions = Psgc::where('code', Auth::user()->region)->get();
            $grants = Grant::where('region', Auth::user()->region)
                ->where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        }

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addColumn('fullname', function (User $user) {
                    if ($user->profile !== null) {
                        return $user->profile->firstName . ' ' . substr($user->profile->middleName, 0, 1) . '. ' . $user->profile->lastName;
                    } else {
                        return '';
                    }
                })
                ->addColumn('userRegion', function (User $user) {
                    if ($user->userRegion !== null) {
                        return $user->userRegion->name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('userProv', function (User $user) {
                    if ($user->profile !== null) {
                        //$province = Psgc::getProvince($user->profile->psgCode);
                        //return $province;
                        return $user->profile->psgCode;
                    } else {
                        return '';
                    }
                })
                ->addColumn('userCity', function (User $user) {
                    if ($user->profile !== null) {
                        //$province = Psgc::getProvince($user->profile->psgCode);
                        //return $province;
                        return $user->profile->psgCode;
                    } else {
                        return '';
                    }
                })
                ->make(true);
        }

        return view('users.newUser', compact('grants', 'regions'));
    }

    public function updateCredential(Request $request)
    {
        $request->validateWithBag('user', [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'same:confirm-password'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        User::updateOrCreate(["id" => Auth::id()], $input);

        $notification = array(
            'message' => 'User credential updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = User::with('profile')->with('roles')->with('userRegion')->orderBy('id', 'DESC')->get();
            $regions = Psgc::where('level', 'Reg')->get();
            $roles = Role::pluck('name', 'name')->all();
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $data = User::with('profile')
                ->where(function ($query) {
                    $query->where('region', Auth::user()->region)
                        ->orwhereNull('region');
                })
                ->where(function ($query) {
                    $query->role(['Applicant', 'Regional Officer', 'Provincial Officer', 'Community Service Officer'])
                        ->ordoesntHave('roles');
                })
                ->orderBy('id', 'DESC')
                ->get();

            $regions = Psgc::where('code', Auth::user()->region)->get();

            $roles = Role::where('name', '<>', 'Admin')
                ->where('name', '<>', 'Executive Officer')
                ->pluck('name', 'name')
                ->all();
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
            $data = User::with('profile')
                ->where(function ($query) {
                    $query->where('region', Auth::user()->region)
                        ->orwhereNull('region');
                })
                ->where(function ($query) {
                    $query->role(['Applicant', 'Provincial Officer', 'Community Service Officer'])
                        ->ordoesntHave('roles');
                })
                ->orderBy('id', 'DESC')
                ->get();

            $data = Registered::whereProvince($data);

            $regions = Psgc::where('code', Auth::user()->region)->get();

            $roles = Role::where('name', '<>', 'Admin')
                ->where('name', '<>', 'Executive Officer')
                ->where('name', '<>', 'Regional Officer')
                ->pluck('name', 'name')
                ->all();
        }

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addColumn('fullname', function (User $user) {
                    if ($user->profile !== null) {
                        return $user->profile->firstName . ' ' . substr($user->profile->middleName, 0, 1) . '. ' . $user->profile->lastName;
                    } else {
                        return '';
                    }
                })
                ->addColumn('userRegion', function (User $user) {
                    if ($user->userRegion !== null) {
                        return $user->userRegion->name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('userProv', function (User $user) {
                    if ($user->profile !== null) {
                        //$province = Psgc::getProvince($user->profile->psgCode);
                        //return $province;
                        return $user->profile->psgCode;
                    } else {
                        return '';
                    }
                })
                ->addColumn('userCity', function (User $user) {
                    if ($user->profile !== null) {
                        //$province = Psgc::getProvince($user->profile->psgCode);
                        //return $province;
                        return $user->profile->psgCode;
                    } else {
                        return '';
                    }
                })
                ->addColumn('roles', function (User $user) {
                    return $user->roles->map(function ($roles) {
                        return  $roles->name;
                    })->implode(', ');
                })
                ->make(true);
        }

        return view('users.index', compact('regions', 'roles'));
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
        $request->validateWithBag('user', [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'same:confirm-password'
            //'roles' => 'required|array|min:1'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user =  User::updateOrCreate(["id" => $request->id], $input);

        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->input('roles'));

        $notification = array(
            'message' => 'User updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = User::with('profile')->find($id);
        $userProfile = Profile::where('user_id', $id)->first();

        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $regions = Psgc::where('level', 'Reg')->get();
        } else {
            if (Auth::user()->region) {
                $regions = Psgc::where('code', Auth::user()->region)->get();
            } else {
                $regions = Psgc::where('level', 'Reg')->get();
            }
        }

        $data = Calendar::with('regionname')
            ->where('region', Auth::user()->region)
            ->orderBy('dateTimeStart', 'DESC')->get();

        $psgCode = $userProfile->psgCode ?? '';
        //$psgCode = Auth::user()->profile->psgCode;
        $grants = array();
        $userRegion = Str::substr($psgCode, 0, 2) . "0000000";

        if ($psgCode != '') {
            $userRegion = Str::substr($psgCode, 0, 2) . "0000000";
            $grants = Grant::where('region', $userRegion)
                ->where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        }

        $region = Psgc::where('code', Str::substr($psgCode, 0, 2) . "0000000")->first();
        $province = Psgc::where('code', Str::substr($psgCode, 0, 4) . "00000")->first();
        $city = Psgc::where('code', Str::substr($psgCode, 0, 6) . "000")->first();
        $barangay = Psgc::where('code', $psgCode)->first();


        $applications = Application::with('grant.psgCode')->where('user_id', $id)->get();

        $payments = AdminCost::where('user_id', $id)->orderby('dateRcvd', 'desc')->get();

        return view('users.show', compact('id', 'student', 'grants', 'applications', 'psgCode', 'regions', 'userProfile', 'userRegion', 'data', 'region', 'province', 'city', 'barangay', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $userRole = $user->roles->pluck('name', 'name')->all();
        return response()->json(['user' => $user, 'userRole' => $userRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Application::where('user_id', $id)->delete();

        $notification = array(
            'message' => 'User Deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function validateApply(Request $request)
    {
        $application = Application::where([
            ['user_id', $request->id],
            ['status', '!=', 'Graduated']
        ])->first();

        if (isset($application)) {
            return response()->json([
                'message' => 'notAvailable'
            ]);
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function COPYvalidateApply(Request $request)
    {
        $application = Application::where([
            ['user_id', $request->id]
        ])->where(function ($query) {
            $query->orWhere('status', '!=', 'On Process')->orWhere('status', '!=', 'Graduated');
        })->first();

        if (isset($application)) {
            return response()->json([
                'message' => 'notAvailable'
            ]);
        }
        return response()->json([
            'message' => 'success'
        ]);
    }
}
