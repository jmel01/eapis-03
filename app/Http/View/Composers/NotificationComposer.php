<?php

namespace App\Http\View\Composers;

use App\ChartArray\Registered;
use App\Models\AdminCost;
use App\Models\Application;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
                $locationId = '';
                $subStrLen = '0';
            } elseif (Auth::user()->hasAnyRole(['Regional Officer'])) {
                $locationId = Str::substr(Auth::user()->region, 0, 2);
                $subStrLen = '2';
            } elseif (Auth::user()->hasAnyRole(['Provincial Officer', 'Community Service Officer'])) {
                $locationId = !empty(Auth::user()->profile->psgCode) ?  Str::substr(Auth::user()->profile->psgCode, 0, 4) : '';
                $subStrLen = '4';
            } else {
                $locationId = '';
                $subStrLen = '';
            }

            $student = User::with('profile')
                ->where(function ($query) {
                    $query->role(['Applicant'])
                        ->ordoesntHave('roles');
                })
                ->orderBy('id', 'DESC')
                ->get();

            $totalNoApplication = count(Registered::whereNotApplied($student));

            $totalAllApplication = Application::join('profiles', 'profiles.user_id', 'applications.user_id')
                ->where([[\DB::raw('substr(profiles.psgCode, 1,' . $subStrLen . ')'),  $locationId]])->count();

            $totalNewApplication = Application::join('profiles', 'profiles.user_id',  'applications.user_id')
                ->where([[\DB::raw('substr(profiles.psgCode, 1,' . $subStrLen . ')'), $locationId]])
                ->where('status', 'New')
                ->orWhere('status', 'On Process')
                ->count();

            $totalApprovedApplication = Application::join('profiles', 'profiles.user_id', 'applications.user_id')
                ->where([[\DB::raw('substr(profiles.psgCode, 1,' . $subStrLen . ')'), $locationId]])
                ->where('status', 'Approved')
                ->count();

            $totalGraduatedApplication = Application::join('profiles', 'profiles.user_id', 'applications.user_id')
                ->where([[\DB::raw('substr(profiles.psgCode, 1,' . $subStrLen . ')'), $locationId]])
                ->where('status', 'Graduated')
                ->count();
        } else {
            $locationId = '';
            $subStrLen = '';
            $totalNoApplication = '';
            $totalAllApplication = '';
            $totalNewApplication = '';
            $totalApprovedApplication = '';
            $totalGraduatedApplication = '';
        }





        $view->with(compact(
            'locationId',
            'subStrLen',
            'totalNoApplication',
            'totalAllApplication',
            'totalNewApplication',
            'totalApprovedApplication',
            'totalGraduatedApplication'
        ));
    }
}
