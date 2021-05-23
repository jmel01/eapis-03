<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ScholarshipComposer
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
            }
        } else {
            $locationId = '';
            $subStrLen = '';
        }

        $view->with(compact('locationId', 'subStrLen'));
    }
}
