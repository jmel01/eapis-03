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
        if (Auth::user()->hasAnyRole(["Applicant"])) {
            return redirect()->route('applicant');
        } elseif (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            return redirect()->route('admin');
        } else {
            return redirect('/dashboard/applicant');
        }
    }
}
