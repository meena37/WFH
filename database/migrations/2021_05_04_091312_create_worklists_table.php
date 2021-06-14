<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Work_Period');
			$table->string('Work_Type');
			$table->string('Work_Nature');
			$table->string('Work_Heading');
			$table->string('Description');
			$table->string('Quantity');
			$table->string('Minutes');
			$table->string('Estimate_Time');
			$table->string('User_id');
			$table->string('Supervisor_id');
			$table->string('Start');
			$table->string('Paused');
			$table->string('Resume');
			$table->string('Complete');
			$table->string('Start_Date');
			$table->string('Paused_Date');
			$table->string('Resume_Date');
			$table->string('Complete_Date');
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
        Schema::dropIfExists('worklists');
    }
}
