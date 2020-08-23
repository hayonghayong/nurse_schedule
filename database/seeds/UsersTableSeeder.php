<?php
use Illuminate\Database\Seeder;

    class UsersTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="UsersTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\User::create([
					"ward_id" => $faker->randomDigit(),
					"name" => $faker->name(),
					"login_id" => $faker->word(),
					"password" => $faker->password(),
					"admin_flg" => $faker->word(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }