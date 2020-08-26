<?php
use Illuminate\Database\Seeder;

    class UsersPatientsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="UsersPatientsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
        }
    }