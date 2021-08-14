<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
			$table->id();
			$table->integer('ref')->nullable();
			$table->integer('associationId')->nullable();
			$table->integer('propertyId')->nullable();
			$table->tinyInteger('isCompany')->nullable();
			$table->string('firstName',100)->nullable();
			$table->string('middleName',100)->nullable();
			$table->string('lastName',100)->nullable();
			$table->string('companyLegalName')->nullable();
			$table->string('inCorporation',50)->nullable();
			$table->string('einNumber',100)->nullable();
			$table->string('contactPerson',100)->nullable();
			$table->string('phoneNumber',50)->nullable();
			$table->string('email',100)->nullable();
			$table->string('whatsapp',100)->nullable();
			$table->text('mailingAddress1');
			$table->text('mailingAddress2');
			$table->string('city',100)->nullable();
			$table->string('state',100)->nullable();
			$table->string('country',50)->nullable();
			$table->string('zip',50)->nullable();
			$table->tinyInteger('documentList')->nullable();
			$table->tinyInteger('history')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->integer('buildingId')->nullable();
			$table->string('sex',10)->nullable();
			$table->string('ethnicity',200)->nullable();
			$table->date('dateOfBirth')->nullable();
			$table->string('occupation',200)->nullable();
			$table->string('picture',200)->nullable();
			$table->integer('if_us_citizen')->nullable();
			$table->string('socialSecurityNumber',200)->nullable();
			$table->string('driverLicense',200)->nullable();
			$table->string('greenCard',200)->nullable();
			$table->string('countryofResidence',100)->nullable();
			$table->string('usVisa',200)->nullable();
			$table->string('passport',200)->nullable();
			$table->date('ownershipStartDate')->nullable();
			$table->string('application_doc',200)->nullable();
			$table->string('board_of_directors_approval',200)->nullable();
			$table->string('background_check',200)->nullable();
			$table->string('property_ownership_proof',200)->nullable();
			$table->timestamps();
	});
    }

    public function down()
    {
        Schema::dropIfExists('owners');
    }
}