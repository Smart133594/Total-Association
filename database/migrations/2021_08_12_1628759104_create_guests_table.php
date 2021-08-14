<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
			$table->id();
			$table->integer('propertyId')->nullable();
			$table->integer('associationId')->nullable();
			$table->text('buildingId');
			$table->integer('typeId')->nullable();
			$table->string('aptNumber',200)->nullable();
			$table->integer('floorNumber')->nullable();
			$table->integer('residentId')->nullable();
			$table->string('firstName',50)->nullable();
			$table->string('middleName',50)->nullable();
			$table->string('lastName',50)->nullable();
			$table->string('phoneNumber',50)->nullable();
			$table->string('email',150)->nullable();
			$table->date('startingDate')->nullable();
			$table->string('duration',200)->nullable();
			$table->string('idDocument')->nullable();
			$table->string('documentList')->nullable();
			$table->string('history')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->string('sex')->nullable();
			$table->string('ethnicity',200)->nullable();
			$table->date('dateOfBirth')->nullable();
			$table->string('picture',200)->nullable();
			$table->integer('if_us_citizen')->nullable();
			$table->string('driverLicense',200)->nullable();
			$table->string('passport',200)->nullable();
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guests');
    }
}