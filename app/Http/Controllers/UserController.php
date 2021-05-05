<?php

namespace App\Http\Controllers;

use App\ChartArray\Registered;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Grant;
use App\Models\Psgc;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function newUser()
    {
        $data = User::with('profile')
            ->where(function ($query) {
                $query->role(['Applicant'])
                    ->ordoesntHave('roles');
            })
            ->orderBy('id', 'DESC')
            ->get();

        $data = Registered::whereNotApplied($data);

        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {

            $regions = Psgc::where('level', 'Reg')->get();
            $grants = Grant::where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
            $regions = Psgc::where('code', Auth::user()->region)->get();
            $grants = Grant::where('region', Auth::user()->region)
                ->where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {

            $regions = Psgc::where('code', Auth::user()->region)->get();
            $grants = Grant::where('region', Auth::user()->region)
                ->where('applicationOpen', '<=', date('Y-m-d'))
                ->where('applicationClosed', '>=', date('Y-m-d'))
                ->get();
        }

        return view('users.newUser', compact('data', 'grants', 'regions'));
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
    public function index()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = User::with('profile')->orderBy('id', 'DESC')->get();
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

        return view('users.index', compact('data',  'regions', 'roles'));
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
        //
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
