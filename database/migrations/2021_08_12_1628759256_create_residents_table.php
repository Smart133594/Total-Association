<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentsTable extends Migration
{
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
			$table->id();
			$table->integer('ref')->nullable();
			$table->integer('associationId')->nullable();
			$table->integer('propertyId')->nullable();
			$table->integer('isOwnerResident')->nullable();
			$table->integer('ownerId')->nullable();
			$table->string('firstName',100)->nullable();
			$table->string('middleName',100)->nullable();
			$table->string('lastName',100)->nullable();
			$table->string('phoneNumber',50)->nullable();
			$table->string('email',150)->nullable();
			$table->string('whatsapp',50)->nullable();
			$table->text('mailingAddress1');
			$table->text('mailingAddress2');
			$table->string('city',100)->nullable();
			$table->string('state',100)->nullable();
			$table->string('country',50)->nullable();
			$table->string('zip',50)->nullable();
			$table->string('documentList')->nullable();
			$table->string('history')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->string('sex',50)->nullable();
			$table->string('ethnicity',200)->nullable();
			$table->date('dateOfBirth')->nullable();
			$table->string('occupation',200)->nullable();
			$table->string('picture',200)->nullable();
			$table->integer('if_us_citizen')->nullable();
			$table->string('socialSecurityNumber',200)->nullable();
			$table->string('driverLicense',200)->nullable();
			$table->string('greenCard',200)->nullable();
			$table->string('countryofResidence',200)->nullable();
			$table->string('usVisa',200)->nullable();
			$table->string('passport',200)->nullable();
			$table->date('ownershipStartDate')->nullable();
			$table->string('application_doc',200)->nullable();
			$table->string('board_of_directors_approval',200)->nullable();
			$table->string('background_check',200)->nullable();
			$table->string('lease_agreament',200)->nullable();
			$table->integer('buildingId')->nullable();
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('residents');
    }
}