<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Psgc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasAnyRole(["Admin", 'Executive Officer'])) {
            $data = Calendar::orderBy('dateTimeStart', 'DESC')->get();
            $regions = Psgc::where('level', 'Reg')->get();
        } else {
            $data = Calendar::where('user_id', Auth::id())->orderBy('dateTimeStart', 'DESC')->get();
            $regions = Psgc::where('code', Auth::user()->region)->get();
        }

        return view('calendars.index', compact('data', 'regions'));
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
        $request->validateWithBag('calendar', [
            'title' => 'required',
            'description' => 'required',
            'dateTimeStart' => 'required',
            'dateTimeEnd',
            'color',
            'region',
        ]);

        $user = [
            "id" => $request->id,
            "user_id" => Auth::id(),
        ];

        $input = $request->all();
        if (empty($request->input('color'))) {
            $input['color'] = '#17a2b8'; // default color if nothing selected
        }

        Calendar::updateOrCreate($user, $input);

        $notification = array(
            'message' => 'Announcement created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('calendars.index')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $announcement = Calendar::find($id);
    
        return response()->json(['announcement' => $announcement]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        //
    }
}
