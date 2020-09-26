<?php
use Illuminate\Database\Seeder;

    class TasksTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="SchedulesTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");

            DB::table('tasks')->insert([
                "schedule_id" => 1,
                "treatment_id"=>1,
                "patient_id"=>1,
                "start_date"=> '2020-09-09 10:00:00',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('tasks')->insert([
                "schedule_id" => 1,
                "treatment_id"=>2,
                "patient_id"=>1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('tasks')->insert([
                "schedule_id" => 2,
                "treatment_id"=>1,
                "patient_id"=>1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);

            DB::table('tasks')->insert([
                "schedule_id" => 2,
                "treatment_id"=>12,
                "patient_id"=>2,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]);
            
        }
    }