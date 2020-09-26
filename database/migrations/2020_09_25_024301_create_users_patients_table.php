<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateUsersPatientsTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("users_patients", function (Blueprint $table) {
                      $table->increments('id');
                      $table->unsignedInteger('schedule_id');
                      $table->unsignedInteger('patient_id');
                      $table->timestamps();
                      $table->softDeletes();

                      $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
                      $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
                    });
                }
    
                /**
                 * Reverse the migrations.
                 *
                 * @return void
                 */
                public function down()
                {
                    Schema::dropIfExists("users_patients");
                }
            }
        