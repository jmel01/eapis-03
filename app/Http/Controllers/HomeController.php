<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->hasAnyRole(["Admin"])) {
            return redirect()->route('admin');
        }
        if (Auth::user()->hasAnyRole(["Executive Officer"])) {
            return redirect()->route('executiveOfficer');
        }
        if (Auth::user()->hasAnyRole(["Regional Officer"])) {
            return redirect()->route('regionalOfficer');
        }
        if (Auth::user()->hasAnyRole(["Provincial Officer"])) {
            return redirect()->route('provincialOfficer');
        }
        if (Auth::user()->hasAnyRole(["Community Service Officer"])) {
            return redirect()->route('communityOfficer');
        }
        if (Auth::user()->hasAnyRole(["Applicant"])) {
            return redirect()->route('applicant');
        } elseif (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            return redirect()->route('admin');
        } else {
            return redirect('/dashboard/applicant');
        }
    }
}
