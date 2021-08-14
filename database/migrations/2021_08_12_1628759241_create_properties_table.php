<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
			$table->id();
			$table->integer('masterassociationId')->default(0);
			$table->integer('associationId')->nullable();
			$table->text('buildingId');
			$table->integer('typeId')->nullable();
			$table->text('address1');
			$table->text('address2');
			$table->string('city',50)->nullable();
			$table->string('state',50)->nullable();
			$table->string('pincode',50)->nullable();
			$table->string('country',30)->nullable();
			$table->tinyInteger('status')->default(1);
			$table->string('ownerFirstName',150)->nullable();
			$table->string('ownerLastName',150)->nullable();
			$table->string('residentFirstName',150)->nullable();
			$table->string('residentLastName',150)->nullable();
			$table->string('aptNumber',200)->nullable();
			$table->string('occupied',100)->nullable();
			$table->integer('floorNumber')->nullable();
			$table->integer('paymentBracket')->nullable();
			$table->timestamps();
	});
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
}