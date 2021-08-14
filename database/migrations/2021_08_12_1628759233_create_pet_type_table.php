<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetTypeTable extends Migration
{
    public function up()
    {
        Schema::create('pet_type', function (Blueprint $table) {
            $table->id();
            $table->string('petType',100)->nullable();
            $table->integer('status')->default(1);
            $table->text('vaccinations_list');
            $table->text('description');
            $table->text('required_by_law');
            $table->text('doc_status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pet_type');
    }
}