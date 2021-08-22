<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('departmentid');
            $table->integer('workerid');
            $table->string('task')->nullable();
            $table->date('date')->nullable();
            $table->integer('priority')->nullable()->comment("0: high, 1: medium, 2: low");
            $table->integer('state')->nullable()->comment("0: assigned, 1: in progress, 2: on hold, 3: canceled, 4: done");
            $table->text('description')->nullable();
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
        Schema::dropIfExists('department_tasks');
    }
}
