<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Grant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RecycleController extends Controller
{
    public function index()
    {

        $users = User::onlyTrashed()->with('profile')->orderBy('deleted_at', 'DESC')->get();
        $grants =  Grant::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        $applications =  Application::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();

        return view('recycle.index', compact('users', 'grants', 'applications'));
    }

    public function destroyApplication($id)
    {
        $user = Application::withTrashed()->find($id);
        $user->forceDelete();

        $notification = array(
            'message' => 'Application successfully deleted permanently.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function restoreApplication($id)
    {
        $user = Application::withTrashed()->find($id);
        $user->restore();

        $notification = array(
            'message' => 'Application restored successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function destroyGrant($id)
    {
        $user = Grant::withTrashed()->find($id);
        $user->forceDelete();

        $notification = array(
            'message' => 'Grant successfully deleted permanently.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function restoreGrant($id)
    {
        $user = Grant::withTrashed()->find($id);
        $user->restore();

        $notification = array(
            'message' => 'Grant restored successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function destroyUser($id)
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();

        $notification = array(
            'message' => 'User account successfully deleted permanently.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();

        $notification = array(
            'message' => 'User account restored successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
