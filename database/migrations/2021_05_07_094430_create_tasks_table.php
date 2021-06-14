<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Timestamp');
			$table->string('Task_type_id');
            $table->string('Task_Shift_id');
			$table->string('Task_Title');
            $table->string('Task_Details');
			$table->string('Task_QTY');
            $table->string('Time_acc_to_task');
			$table->string('To_do_Time');
            $table->string('Proposed_Date');
			$table->string('Proposed_Time');
			$table->string('Plan');
			$table->string('Start_Date');
			$table->string('Paused_Date');
			$table->string('Resume_Date');
			$table->string('Complete_Date');
			$table->string('Time_Taken');
			$table->string('Verification');
			$table->string('Partial');
			$table->string('Pending');
			$table->string('Verification_Task');
			$table->string('User_id');
			$table->string('Supervisor_id');
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
        Schema::dropIfExists('tasks');
    }
}
