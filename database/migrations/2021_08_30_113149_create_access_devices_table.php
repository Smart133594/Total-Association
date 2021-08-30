<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_devices', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 100)->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->tinyInteger('active')->comment("0: deactive, 1: active")->default(0);
            $table->string('etc', 255)->nullable();
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
        Schema::dropIfExists('access_devices');
    }
}
