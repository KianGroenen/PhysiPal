<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersInterests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->integer('interestid')->unsigned();
            $table->foreign('interestid')->references('id')->on('interests')->onDelete('cascade');
            $table->string('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_interests');
    }
}
