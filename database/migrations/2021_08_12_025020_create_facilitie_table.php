<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('Facility', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->integer('facilitiesTypeId')->nullable();
            $table->string('unit', 200)->nullable();
            $table->date('suspendFrom')->nullable();
            $table->date('suspendTo')->nullable();
            $table->string('suspendTitle', 200)->nullable();
            $table->text('suspendDescription')->nullable();
            $table->date('paidUntil')->nullable();
            $table->integer('status')->default(1);
            $table->date('location')->nullable();
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
        Schema::dropIfExists('facilities');
    }
}
