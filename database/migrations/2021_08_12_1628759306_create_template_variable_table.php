<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateVariableTable extends Migration
{
    public function up()
    {
        Schema::create('template_variable', function (Blueprint $table) {
            $table->id();
            $table->string('variable',200)->nullable();
            $table->string('columnName',200)->nullable();
            $table->integer('onlyfacility')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('template_variable');
    }
}