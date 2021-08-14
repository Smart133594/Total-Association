<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentTable extends Migration
{
    public function up()
    {
        Schema::create('incident', function (Blueprint $table) {
			$table->id();
			$table->integer('ref')->nullable();
			$table->string('incidentTitle')->nullable();
			$table->text('incidentDescription');
			$table->integer('propertyId')->nullable();
			$table->integer('individual')->default(0);
			$table->string('name_of_description')->nullable();
			$table->string('dateTime',100)->nullable();
			$table->integer('policeInvolved')->default(0);
			$table->text('policeReport');
			$table->string('outcome',200)->nullable();
			$table->integer('status')->default(1);
			$table->string('individualType',50)->nullable();
			$table->integer('responsiblePersonId')->nullable();
			$table->decimal('fine_amount',10,2)->nullable();
			$table->timestamp('report_send_time')->nullable();
			$table->decimal('paid_amount',10,2)->nullable();
			$table->string('check_image',200)->nullable();
			$table->string('dispute_form',200)->nullable();
			$table->integer('fine_status')->default(0);
			$table->string('committee_packege',200)->nullable();
			$table->string('committee_decision',200)->nullable();
			$table->string('decision_form',200)->nullable();
			$table->decimal('new_fine_amount',10,2)->nullable();
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incident');
    }
}