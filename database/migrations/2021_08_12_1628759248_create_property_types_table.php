<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyTypesTable extends Migration
{
    public function up()
    {
        Schema::create('property_types', function (Blueprint $table) {
			$table->id();
			$table->integer('associationId')->nullable();
			$table->string('type',25)->nullable();
			$table->string('propertyName')->nullable();
			$table->integer('whichBuilding')->nullable();
			$table->integer('maintainenceFeeBracketId')->nullable();
			$table->text('propertyDescription');
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_types');
    }
}