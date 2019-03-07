<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding Users with fake data for testing purpose');
        $qty_records = 25;
        $faker = Faker::create('es_ES');

        for ($i = 1; $i <= $qty_records; $i++) {
            $user = new User();
            $user->name = $faker->name. ' '. $faker->lastName;
            $user->email = $faker->unique()->email;
            $user->password = bcrypt('password');
            $user->remember_token = bcrypt('password');
            $user->save();
        }

        $this->command->info('Seeding Users with fake data for testing purpose, successfully completed');


    }
}
