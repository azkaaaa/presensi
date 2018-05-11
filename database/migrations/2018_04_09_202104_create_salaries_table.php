<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('month')->unsigned();
            $table->integer('years')->unsigned();
            $table->integer('list')->unsigned();
            $table->integer('salary')->unsigned();
            $table->integer('total_presences')->unsigned();
            $table->integer('all_overtime')->unsigned();
            $table->integer('total_transport')->unsigned();
            $table->integer('total_overtime')->unsigned();
            $table->integer('total_salary')->unsigned();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
