<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreatePatientsTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("patients", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('ward_id');
						$table->string('name');
						$table->date('birthday');
						$table->char('sex',1);
						$table->integer('room')->nullable();
						$table->date('hospitalization_date')->nullable();
						$table->date('surgery_date')->nullable();
						$table->text('memo')->nullable();
						$table->char('discharge_flg',1);
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
                    Schema::dropIfExists("patients");
                }
            }
        