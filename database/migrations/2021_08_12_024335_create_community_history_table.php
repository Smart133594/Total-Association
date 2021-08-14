<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication_history', function (Blueprint $table) {
            $table->id();
            $table->string('sendto', 200)->nullable();
            $table->string('sendtoemail', 200)->nullable();
            $table->string('subject', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('type', 20)->nullable();
            $table->integer('rentId')->nullable();
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
        Schema::dropIfExists('communication_history');
    }
}
