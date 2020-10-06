<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateTreatmentsTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("treatments", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('ward_id');
						$table->string('name');
						$table->integer('time_required');
						$table->char('color_code',7)->nullable();
						$table->char('required_flg',1);
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
                    Schema::dropIfExists("treatments");
                }
            }
        