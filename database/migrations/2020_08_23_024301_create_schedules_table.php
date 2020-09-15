<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateSchedulesTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("schedules", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('ward_id');
						$table->integer('user_id');
						$table->integer('treatment_id');
						$table->integer('patient_id');
						$table->dateTime('start_date')->nullable();
            $table->char('end_flg',1)->nullable();
            $table->dateTime('end_time')->nullable();
						$table->timestamps();
						$table->softDeletes();
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
        