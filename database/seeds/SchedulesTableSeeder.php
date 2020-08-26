<?php
use Illuminate\Database\Seeder;

    class SchedulesTableSeeder extends Seeder
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
            
        }
    }