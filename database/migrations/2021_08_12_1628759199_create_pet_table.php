<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetTable extends Migration
{
    public function up()
    {
        Schema::create('pet', function (Blueprint $table) {
			$table->id();
			$table->integer('pettypeId')->nullable();
			$table->integer('propertyId')->nullable();
			$table->integer('ownerId')->nullable();
			$table->string('petName',200)->nullable();
			$table->text('breedAndDesc');
			$table->string('image',200)->nullable();
			$table->text('shotsValidDate');
			$table->string('documents')->nullable();
			$table->tinyInteger('supportAnimal')->default(0);
			$table->string('supportDocuments',200)->nullable();
			$table->tinyInteger('status')->default(0);
			$table->date('approveDate')->nullable();
			$table->string('approveBy',200)->nullable();
			$table->string('approvalDocument')->nullable();
			$table->integer('pet_ref')->nullable();
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pet');
    }
}