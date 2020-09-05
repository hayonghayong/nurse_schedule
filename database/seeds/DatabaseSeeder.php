<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //********************************************
        // Cmd:[ php artisan db:seed ]
        //********************************************
        $this->call(UsersTableSeeder::class);
        $this->call(TreatmentsTableSeeder::class);
        $this->call(PatientsTableSeeder::class);
        $this->call(SchedulesTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(TeamUsersTableSeeder::class);
        $this->call(PatientUserTableSeeder::class);
        $this->call(AttendancesTableSeeder::class);
        $this->call(HospitalsTableSeeder::class);
        $this->call(WardsTableSeeder::class);
        $this->call(TeamUserUserTableSeeder::class);
        $this->call(ScheduleTreatmentTableSeeder::class);
        $this->call(PatientScheduleTableSeeder::class);
   }
}