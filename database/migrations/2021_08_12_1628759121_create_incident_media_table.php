<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentMediaTable extends Migration
{
    public function up()
    {
        Schema::create('incident_media', function (Blueprint $table) {
            $table->id();
            $table->string('documents')->nullable();
            $table->string('type',100)->nullable();
            $table->integer('ref')->nullable();
            $table->date('uploadOn')->nullable();
            $table->string('uploadedBy',200)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incident_media');
    }
}