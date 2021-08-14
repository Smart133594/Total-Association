<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerResidentDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('owner_resident_documents', function (Blueprint $table) {
			$table->id();
			$table->string('documentName',200)->nullable();
			$table->string('documents',200)->nullable();
			$table->string('uploadedBy',200)->nullable();
			$table->date('uploadOn')->nullable();
			$table->string('type',25)->nullable();
			$table->text('description');
			$table->integer('ref')->nullable();
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('owner_resident_documents');
    }
}