<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTypesTable extends Migration
{
    public function up()
    {
        Schema::create('facilities_types', function (Blueprint $table) {
            $table->id();
            $table->integer('ref')->nullable();
            $table->string('typeName',200)->nullable();
            $table->string('termType',51)->nullable();
            $table->text('typeDescription')->nullable();
            $table->tinyInteger('residentOnly')->default(0);
            $table->integer('limitedToRentalPerYear')->nullable();
            $table->integer('limitedToRentalperEvent')->nullable();
            $table->string('limitedType',100)->nullable();
            $table->tinyInteger('videoRequired')->nullable();
            $table->string('calenderType',100)->nullable();
            $table->tinyInteger('rentedOnline')->nullable();
            $table->tinyInteger('autoRenew')->nullable();
            $table->string('paymentType',50)->nullable();
            $table->decimal('HourlyPrice',10,2)->nullable();
            $table->integer('HourlyTime')->nullable();
            $table->string('isHourly',50)->nullable();
            $table->decimal('DailyPrice',10,0)->nullable();
            $table->integer('DailyTime')->nullable();
            $table->tinyInteger('isDaily')->nullable();
            $table->decimal('WeeklyPrice',10,0)->nullable();
            $table->integer('WeeklyTime')->nullable();
            $table->tinyInteger('isWeekly')->nullable();
            $table->decimal('MonthlyPrice',10,0)->nullable();
            $table->integer('MonthlyTime')->nullable();
            $table->tinyInteger('isMonthly')->nullable();
            $table->decimal('YearlyPrice',10,0)->nullable();
            $table->integer('YearlyTime')->nullable();
            $table->tinyInteger('isYearly')->nullable();
            $table->tinyInteger('contractRequired')->nullable();
            $table->string('cancellationNoticeTime',50)->nullable();
            $table->string('quiteTiemHour',20)->nullable();
            $table->string('quiteTiemMiniuts',20)->nullable();
            $table->integer('maxOccupants')->nullable();
            $table->decimal('secirityDeposite',10,2)->nullable();
            $table->tinyInteger('noOfPetAllowed')->nullable();
            $table->integer('maxWightPet')->nullable();
            $table->decimal('petDeposit',10,2)->nullable();
            $table->integer('isPetDepositeRefundable')->nullable();

            $table->integer('parkingAvailable')->nullable();
            $table->integer('ParkingFees')->nullable();
            $table->integer('freeParkingSpace')->nullable();
            $table->decimal('partyCleanupFees',10,2)->nullable();
            $table->integer('smokingArea')->nullable();
            $table->integer('moveinInspectionRequired')->nullable();
            $table->string('emergencyContactFname',100)->nullable();
            $table->string('emergencyContactLname',100)->nullable();
            $table->string('emergencyContactEmail',100)->nullable();
            $table->string('emergencyContactPhone',100)->nullable();
            $table->integer('status')->default(1);
            $table->string('image',200)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facilities_types');
    }
}
