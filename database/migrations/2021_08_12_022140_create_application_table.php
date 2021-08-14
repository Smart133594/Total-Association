<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('applicationType', 100)->nullable();
            $table->string('firstName', 100)->nullable();
            $table->string('middleName', 100)->nullable();
            $table->string('lastName', 100)->nullable();
            $table->string('phoneNo', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('socialSecurityNo', 15)->nullable();
            $table->string('drivingLicenseNo', 25)->nullable();
            $table->string('drivingLicenseImage', 255)->nullable();
            $table->string('address1')->text();
            $table->string('address2')->text();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('pincode', 50)->nullable();
            $table->integer('associationId')->nullable();
            $table->string('placeOfWork', 100)->nullable();
            $table->string('currentIncome', 255)->nullable();
            $table->string('textReturn', 255)->nullable();
            $table->boolean('isAgent')->default(false);
            $table->string('agentFirstName', 100)->nullable();
            $table->string('agentMiddleName', 100)->nullable();
            $table->string('agentLastName', 100)->nullable();
            $table->string('agentPhoneNo', 100)->nullable();
            $table->string('agentEmailId', 100)->nullable();
            $table->tinyInteger('paymentStatus')->default(0);
            $table->double('amount', 10, 2)->nullable();
            $table->string('transactionId', 100)->nullable();
            $table->string('paymentType', 50)->nullable();
            $table->dateTime('dateTime');
            $table->tinyInteger('status')->default(1)->comments(" 1. In process 2. Expired 3. Denied 4 approved");
            $table->tinyInteger('isEmailVarified')->default(0);
            $table->integer('background_check')->default(0);
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
        Schema::dropIfExists('applications');
    }
}
