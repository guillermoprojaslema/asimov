<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::all();
        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = \Calendar::event(
                "Appointment with " . $appointment->user()->first()->name, //event title
                false, //full day event?
                $appointment->getStart(), //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $appointment->getEnd(), //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                $appointment->getId(), //optional event ID
                [
                    'url' => url('appointments/' . $appointment->getId()),
                    //any other full-calendar supported parameters
                ]
            );
        }

        $data['calendar'] = \Calendar::addEvents($events)
            ->setOptions([ //set fullcalendar options
                'firstDay' => 1,
                'themeSystem' => 'bootstrap3'
            ]);


        return view('appointments.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['appointment'] = Appointment::findOrFail($id);
        return view('appointments.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['appointment'] = Appointment::findOrFail($id);
        return view('appointments.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(null, 204);
    }
}
