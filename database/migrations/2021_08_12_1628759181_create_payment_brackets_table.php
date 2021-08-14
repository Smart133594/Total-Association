<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentBracketsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_brackets', function (Blueprint $table) {
			$table->id();
			$table->integer('associationId')->nullable();
			$table->string('payBracketName',100)->nullable();
			$table->text('description');
			$table->integer('feePaidPerMonth')->nullable();
			$table->decimal('feesValue',10,2);
			$table->float('budget')->nullable();
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_brackets');
    }
}