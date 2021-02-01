<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        }

        return redirect()->route('applicant');
    }

    public function checker(){
        if (Auth::check()) {
            if(session('audit_trail_id') == ''){
                $auditTrail = AuditTrail::create([
                    'user_id' => Auth::id()
                ]);

                session(['audit_trail_id' => $auditTrail->id]);
            }

            return redirect('/home');
        }
        Session::flush();
        return view('welcome');
    }
}
