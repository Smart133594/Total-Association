<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailmanageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailmanage', function (Blueprint $table) {
            $table->id();
            $table->string('from');
            $table->string('to');
            $table->text('title');
            $table->text('email');
            $table->string('location');
            $table->integer('folder');
            $table->integer('flag');
            $table->integer('read');
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
        Schema::dropIfExists('emailmanage');
    }
}
