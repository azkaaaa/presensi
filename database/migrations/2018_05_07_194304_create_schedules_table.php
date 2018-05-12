<?php

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
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('shift_id')->unsigned();
            $table->integer('week_id')->unsigned();
            $table->integer('day_id')->unsigned();
            $table->integer('month_id')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('list')->unsigned();
            $table->string('status');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->foreign('day_id')->references('id')->on('days');
            $table->foreign('week_id')->references('id')->on('weeks');
            $table->foreign('month_id')->references('id')->on('months');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
