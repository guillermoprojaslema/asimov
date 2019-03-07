<?php

use Illuminate\Database\Seeder;
use App\Appointment;
use Faker\Factory as Faker;
use Carbon\Carbon;


class AppointmentTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding Appointments');
        $qty_records_per_day = 10;
        $qty_records_days = 7;
        $faker = Faker::create('es_ES');
        $datetime = Carbon::create(2019, 3, 6, 9, 0, 0, null);

        for ($i = 1; $i <= $qty_records_days; $i++) {
            for ($j = 1 ; $j<= $qty_records_per_day; $j++){

                $appointment = new Appointment();
                $appointment->start = $datetime->format('Y-m-d H:i:s');
                $appointment->user_id = $faker->numberBetween(1, 25);
                $appointment->save();
                $datetime->addHour();
            }

            $datetime->subHours(10)->addDay();
        }

        $this->command->info('Seeding Appointments successfully completed');
    }
}
