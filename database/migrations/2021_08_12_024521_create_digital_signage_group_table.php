<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalSignageGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital-signage-group', function (Blueprint $table) {
            $table->id();
            $table->string('groupName')->nullable();
            $table->string('logo')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('heading1')->nullable();
            $table->string('heading2')->nullable();
            $table->string('heading3')->nullable();
            $table->string('heading4')->nullable();
            $table->string('heading5')->nullable();
            $table->string('heading6')->nullable();
            $table->string('heading7')->nullable();
            $table->string('heading8')->nullable();
            $table->string('heading9')->nullable();
            $table->string('heading10')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(1);
            $table->integer('is_changed')->default(0);
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
        Schema::dropIfExists('digital-signage-group');
    }
}
