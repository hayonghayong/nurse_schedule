<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnWardIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_patient', function (Blueprint $table) {
          $table->dropColumn('ward_id');
        });

        Schema::table('schedules', function (Blueprint $table) {
          $table->dropColumn('ward_id');
        });

        Schema::table('teams', function (Blueprint $table) {
          $table->dropColumn('ward_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
          $table->dropColumn('ward_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_patient', function (Blueprint $table) {
            //
        });
    }
}
