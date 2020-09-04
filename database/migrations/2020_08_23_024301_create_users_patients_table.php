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
						$table->integer('ward_id');
						$table->integer('user_id');
						$table->integer('patient_id');
						$table->integer('end_flg');
						$table->timestamps();
            $table->softDeletes();
            
            // // 外部キー制約
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

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
        