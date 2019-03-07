<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['start_date', 'start_time', 'user_id'];
    protected $table = "appointments";

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
