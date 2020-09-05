<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamUserUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_user_user', function (Blueprint $table) {
            $table->unsignedInteger('team_user_id');
            $table->unsignedInteger('user_id');
            $table->primary(['team_user_id', 'user_id']);
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('team_user_id')
            //     ->references('id')
            //     ->on('team_users')
            //     ->onDelete('cascade');
            // $table->foreign('user_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_user_user');
    }
}
