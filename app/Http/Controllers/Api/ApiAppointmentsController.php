<?php

namespace App\Http\Controllers\Api;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Validator;
use DB;


class ApiAppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = DB::table('appointments')
            ->leftjoin('users', 'users.id', '=', 'appointments.user_id')
            ->select('appointments.*', 'users.name', 'users.last_name', 'users.email')
            ->get();


        return response()->json($appointments, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start' => 'required|date',
            'name' => 'required|min:2|max:191',
            'last_name' => 'required|min:2|max:191',
            'email' => 'required|email|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json(null, 400);
        } else {
            if ($this->isAvailable($request->start) && $this->isbussinesHour($request->start)) {

                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    $user = new User();
                    $user->password = bcrypt('password');
                    $user->remember_token = bcrypt('password');
                }
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                $appointment = Appointment::where('start', $request->start)->first();

                if ($appointment) {
                    $appointment->start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
                    $appointment->end = Carbon::parse($request->start)->addHour()->format('Y-m-d H:i:s');
                    $appointment->user_id = $user->id;
                    $appointment->save();
                } else {
                    return response()->json(null, 400);
                }

                return response()->json($appointment, 201);
            } else {

                return response()->json(null, 400);
            }
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
        $appointment = DB::table('appointments')
            ->leftjoin('users', 'users.id', '=', 'appointments.user_id')
            ->select('appointments.*', 'users.name', 'users.last_name', 'users.email')
            ->where('appointments.id', $id)
            ->first();

        if ($appointment) {
            return response()->json($appointment, 200);
        } else {
            return response()->json(null, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $appointment = DB::table('appointments')
            ->join('users', 'users.id', '=', 'appointments.user_id')
            ->select('appointments.*', 'users.name', 'users.last_name', 'users.email')
            ->where('appointments.id', $id)
            ->first();


        if ($appointment) {
            return response()->json($appointment, 200);
        } else {
            return response()->json(null, 404);
        }


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

        $validator = Validator::make($request->all(), [
            'start' => 'required|date',
            'name' => 'required|min:2|max:191',
            'last_name' => 'required|min:2|max:191',
            'email' => 'required|email|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json(null, 400);
        } else {
            if ($this->isAvailable($request->start) && $this->isbussinesHour($request->start)) {

                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    $user = new User();
                    $user->password = bcrypt('password');
                    $user->remember_token = bcrypt('password');
                }
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                $appointment = Appointment::findOrFail($id);
                if ($appointment) {
                    $appointment->start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
                    $appointment->end = Carbon::parse($request->start)->addHour()->format('Y-m-d H:i:s');
                    $appointment->user_id = $user->id;
                    $appointment->save();
                } else {
                    return response()->json(null, 400);
                }

                return response()->json($appointment, 201);
            } else {
                return response()->json(null, 400);
            }
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
        $appointments = Appointment::whereNull('user_id')->where('start', '<>', $start_datetime->format('Y-m-d H:i:s'))->get();
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

        if ($start_time->isWeekday() && $start_time->lessThanOrEqualTo($from) && $start_time->addHour()->lessThanOrEqualTo($to)) {
            return true;
        } else {
            return false;
        }
    }
}
