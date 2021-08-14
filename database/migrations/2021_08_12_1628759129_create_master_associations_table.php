<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAssociationsTable extends Migration
{
    public function up()
    {
        Schema::create('master_associations', function (Blueprint $table) {
			$table->id();
			$table->string('einNumber',100)->nullable();
			$table->string('legalName',100)->nullable();
			$table->string('name',100)->nullable();
			$table->text('address1');
			$table->text('address2');
			$table->string('city',50)->nullable();
			$table->string('state',30)->nullable();
			$table->string('country',25)->nullable();
			$table->string('pincode',50)->nullable();
			$table->string('phoneNo',50)->nullable();
			$table->string('fax',20)->nullable();
			$table->string('email',50)->nullable();
			$table->string('whatsappNo',50)->nullable();
			$table->string('website')->nullable();
			$table->string('facebook')->nullable();
			$table->string('twitter')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_associations');
    }
}