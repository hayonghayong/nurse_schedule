<?php
use Illuminate\Database\Seeder;

    class TeamUsersTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="TeamUsersTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
        }
    }