<?php

namespace App\Http\Controllers\Api;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ApiAppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['appointments'] = Appointment::all();
        $data['now'] = Carbon::now();
        return response()->json($data, 201);
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

        if ($this->isAvailable($request->start) && $this->isbussinesHour($request->start)) {
            $appointment = new Appointment();
            $appointment->start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $appointment->end = Carbon::parse($request->start)->addHour()->format('Y-m-d H:i:s');
            $appointment->user_id = 1; // TODO: Que sea el usuario que esté logueado
            $appointment->save();





            return response()->json($appointment, 201);
        } else {
            return response()->json(null, 400);
        }


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
        $data['user'] = $data['appointment']->user()->first();
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
        $data['user'] = $data['appointment']->user()->email;
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
        $appointment = Appointment::findOrFail($id);

        if ($this->isAvailable($request->start) && $this->isbussinesHour($request->start)) {
            $appointment->start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $appointment->end = Carbon::parse($request->start)->addHour()->format('Y-m-d H:i:s');
            $appointment->user_id = 1; // TODO: Que sea el usuario que esté logueado
            $appointment->save();
            return response()->json($appointment, 201);
        } else {
            return response()->json(null, 400);
        }
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

    private function isAvailable($start_datetime)
    {
        $start_datetime = Carbon::parse($start_datetime);
        $appointments = Appointment::all();
        foreach ($appointments as $appointment) {
            if ($start_datetime->diffInHours($appointment->start) < 1) {
                return false;
            }
        }
        return true;

    }

    private function isbussinesHour($start_time)
    {
        $from = Carbon::createFromTime(9, 0, 0);
        $to = Carbon::createFromTime(18, 0, 0);
        $start_time = Carbon::parse($start_time);
        if ($start_time->isWeekday() && $start_time->greaterThanOrEqualTo($from) && $start_time->addHour()->greaterThanOrEqualTo($to)) {
            return true;
        } else {
            return false;
        }
    }
}
