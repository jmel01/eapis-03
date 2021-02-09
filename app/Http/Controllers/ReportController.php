<?php

namespace App\Http\Controllers;

use App\Models\AdminCost;
use App\Models\Application;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function formA()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
        } else {
        }

        return view('reports.formA');
    }

    public function formB()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = Application::with('applicant')
                ->where('status', 'Graduated')
                ->get();
        } else {
            $regionId = Str::substr(Auth::user()->region, 0, 2);
            $data = Application::with(['applicant' => function ($query) use ($regionId) {
                $query->where([[\DB::raw('substr(psgCode, 1, 2)'), '=', $regionId]]);
            }])
                ->where('status', 'Graduated')
                ->get();
        }

        return view('reports.formB', compact('data'));
    }

    public function formC()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = Application::with('applicant')
                ->where('status', 'Terminated-FSD')
                ->orWhere('status', 'Terminated-FG')
                ->orWhere('status', 'Terminated-DS')
                ->orWhere('status', 'Terminated-NE')
                ->orWhere('status', 'Terminated-FPD')
                ->orWhere('status', 'Terminated-EOGS')
                ->orWhere('status', 'Terminated-Others')
                ->get();
        } else {
            $regionId = Str::substr(Auth::user()->region, 0, 2);
            $data = Application::with(['applicant' => function ($query) use ($regionId) {
                $query->where([[\DB::raw('substr(psgCode, 1, 2)'), '=', $regionId]]);
            }])
                ->orWhere('status', 'Terminated-FSD')
                ->orWhere('status', 'Terminated-FG')
                ->orWhere('status', 'Terminated-DS')
                ->orWhere('status', 'Terminated-NE')
                ->orWhere('status', 'Terminated-FPD')
                ->orWhere('status', 'Terminated-EOGS')
                ->orWhere('status', 'Terminated-Others')
                ->get();
        }
        return view('reports.formC', compact('data'));
    }

    public function formD()
    {
        return view('reports.formD');
    }

    public function formE()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = AdminCost::whereNull('user_id')->get();
        } else {
            $regionId = Str::substr(Auth::user()->region, 0, 2);
            $data = AdminCost::whereNull('user_id')
                ->where([[\DB::raw('substr(province, 1, 2)'), '=', $regionId]])
                ->get();
        }
        return view('reports.formE', compact('data'));
    }

    public function formF()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = AdminCost::select(DB::raw('province'))->groupBy('province')->get();
        } else {
            $regionId = Str::substr(Auth::user()->region, 0, 2);
            $data = AdminCost::select(DB::raw('province'))
                ->where([[\DB::raw('substr(province, 1, 2)'), '=', $regionId]])
                ->groupBy('province')
                ->get();
        }
        $adminCosts = AdminCost::select(DB::raw('sum(amount) as amount, province'))->whereNull('user_id')->groupBy('province')->get();
        $actualPayments = AdminCost::select(DB::raw('sum(amount) as amount, province'))->whereNotNull('user_id')->groupBy('province')->get();

        $level = array(
            'college' => $this->grantees('College'),
            'highSchool' => $this->grantees('High School'),
            'elementary' => $this->grantees('Elementary'),
            'vocational' => $this->grantees('Vocational'),
            'total' => $this->grantees('noWhere')
        );

        return view('reports.formF', compact('data', 'adminCosts', 'actualPayments', 'level'));
    }

    public function grantees($level)
    {
        return Application::join('admin_costs', 'admin_costs.application_id', '=', 'applications.id')
            ->where(function ($query) use ($level) {
                if ($level != 'noWhere') {
                    $query->where('applications.level', $level);
                }
            })
            ->select(DB::raw('count(applications.level) as levelCount, admin_costs.province'))
            ->whereNotNull('admin_costs.user_id')
            ->groupBy('admin_costs.province')
            ->get();
    }

    public function formG()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = AdminCost::whereNotNull('user_id')->get();
        } else {
            $regionId = Str::substr(Auth::user()->region, 0, 2);
            $data = AdminCost::whereNotNull('user_id')
                ->where([[\DB::raw('substr(province, 1, 2)'), '=', $regionId]])
                ->get();
        }
        return view('reports.formG', compact('data'));
    }

    public function formH()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
        } else {
        }
        return view('reports.formH');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
