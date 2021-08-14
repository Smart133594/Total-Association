<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesRentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities_rent', function (Blueprint $table) {
            $table->id();
            $table->integer('facilities_id')->nullable();
            $table->integer('isResident')->nullable();
            $table->integer('associationId')->nullable();
            $table->integer('buildingId')->nullable();
            $table->integer('propertyId')->nullable();
            $table->string('whome_type', 50)->nullable();
            $table->integer('whome')->nullable();
            $table->string('RentrsName', 200)->nullable();
            $table->string('RentrsPhone', 100)->nullable();
            $table->string('RentrsEmail', 100)->nullable();
            $table->text('RentrsAddress')->nullable();
            $table->string('RentrsIdproof', 200)->nullable();
            $table->string('video', 200)->nullable();
            $table->string('signedContract', 200)->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->integer('paymentType')->nullable();
            $table->integer('paymentStatus')->nullable();
            $table->string('NameOnCard', 150)->nullable();
            $table->string('cardType', 20)->nullable();
            $table->string('cardNumber', 20)->nullable();
            $table->string('expMonth', 10)->nullable();
            $table->string('expYear', 10)->nullable();
            $table->string('cvv', 10)->nullable();
            $table->string('ccFront', 200)->nullable();
            $table->string('ccBack', 200)->nullable();
            $table->string('noteSubject', 200)->nullable();
            $table->text('noteDetails')->nullable();
            $table->string('fromDate', 100)->nullable();
            $table->string('fromTime', 200)->nullable();
            $table->string('toDate', 100)->nullable();
            $table->string('toTime', 200)->nullable();
            $table->string('cheque', 200)->nullable();
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
        Schema::dropIfExists('facilities_rent');
    }
}
