<?php

use Illuminate\Database\Seeder;
use App\Appointment;
use Faker\Factory as Faker;
use Carbon\Carbon;


class AppointmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding Appointments with fake data for testing purposes. This may take several minutes');
        $qty_records_per_day = 9;
        $qty_records_days = 31;
        $faker = Faker::create('es_ES');
        $datetime = Carbon::create(2019, 3, 1, 9, 0, 0, null);

        for ($i = 1; $i <= $qty_records_days; $i++) {
            for ($j = 1; $j <= $qty_records_per_day; $j++) {

                if ($datetime->isWeekday()) {
                    $appointment = new Appointment();
                    $appointment->start = $datetime->format('Y-m-d H:i:s');
                    $appointment->end = $datetime->addHour()->format('Y-m-d H:i:s');
                    $appointment->user_id = $faker->randomElement([null, $faker->numberBetween(1, 25)]);
                    $appointment->save();
                }
                else{
                    $datetime->addDay();
                    $j--;
                }
            }

            $datetime->subHours(9)->addDay();
        }

        $this->command->info('Seeding Appointments with fake data for testing purposes, successfully completed');
    }
}
