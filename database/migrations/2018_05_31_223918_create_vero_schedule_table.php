<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeroScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vero_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('first_week')->unsigned();
            $table->integer('second_week')->unsigned();
            $table->integer('third_week')->unsigned();
            $table->integer('fourth_week')->unsigned();
            $table->integer('day_id')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('list')->unsigned();
            $table->string('status');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('day_id')->references('id')->on('days');
            // $table->foreign('day_id')->references('id')->on('days');
            // $table->foreign('week_id')->references('id')->on('weeks');
            // $table->foreign('month_id')->references('id')->on('months');
            // $table->foreign('overtime_id')->references('id')->on('overtime_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vero_schedule');
    }
}
