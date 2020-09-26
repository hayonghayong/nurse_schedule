<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateTasksTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                  Schema::create("tasks", function (Blueprint $table) {
                    $table->increments('id');
                    $table->unsignedInteger('schedule_id');
                    $table->unsignedInteger('treatment_id');
                    $table->unsignedInteger('patient_id');
                    $table->dateTime('start_date')->nullable();
                    $table->char('end_flg',1)->nullable();
                    $table->dateTime('end_time')->nullable();
                    $table->timestamps();
                    $table->softDeletes();

                  // 外部キー制約
                  $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
                  $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
                  $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
                });


                }
                /**
                 * Reverse the migrations.
                 *
                 * @return void
                 */
                public function down()
                {
                    Schema::dropIfExists("schedules");
                }
            }
        