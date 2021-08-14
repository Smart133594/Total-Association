<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('pet_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_ref')->nullable();
            $table->string('tags',200)->nullable();
            $table->string('documents',200)->nullable();
            $table->integer('required_by_law')->nullable();
            $table->integer('status')->nullable();
            $table->date('exp_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pet_documents');
    }
}