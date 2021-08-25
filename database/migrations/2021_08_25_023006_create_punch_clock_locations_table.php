<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunchClockLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punch_clock_locations', function (Blueprint $table) {
            $table->id();
            $table->integer('punchclockid');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('country')->nullable();
            $table->string('area')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->integer('type')->default(0)->comment("0: clock in, 1: clock out");
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
        Schema::dropIfExists('punch_clock_locations');
    }
}
