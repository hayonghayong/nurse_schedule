<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateTeamUsersTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("team_users", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('ward_id');
						$table->integer('user_id');
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
                    Schema::dropIfExists("team_users");
                }
            }
        