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
                      $table->unsignedInteger('team_id');
                      $table->unsignedBigInteger('user_id');
                      $table->timestamps();
                      $table->softDeletes();

                      $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
                      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        