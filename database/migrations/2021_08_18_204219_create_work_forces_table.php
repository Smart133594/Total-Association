<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkForcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_forces', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('ssn')->nullable()->comment("Social Security number");
            $table->integer('worker_type')->default(0)->comment("0: employee, 1: sub constractor");
            $table->integer('departmentid')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('salary_structure')->default(0)->comment("0: global, 1: per hour");
            $table->integer('salary')->default(0);
            $table->string('avatar')->nullable();
            $table->string('idcard_image')->nullable();
            $table->string('contracts_image')->nullable();
            $table->string('access_control_device')->nullable();
            $table->string('punch_clock_code')->nullable();
            $table->string('employee_pwd')->nullable();
            $table->string('manage_pwd')->nullable();
            $table->integer('active_state')->default(0)->comment("0: active, 1: archive");
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
        Schema::dropIfExists('work_forces');
    }
}
