<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('id_card')->unique();
            $table->date('birthday');
            $table->string('religion');
            $table->text('address');
            $table->string('phone')->unique();
            $table->string('education');
            $table->string('account_number')->unique();
            $table->string('profile_picture');
            $table->integer('position_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
