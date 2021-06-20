<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateTaskStatusHistoryTable extends Migration
  {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('task_status_history', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('task_id')->default(0);
        $table->bigInteger('user_id')->default(0);
        $table->tinyInteger('from_status')->default(0);
        $table->tinyInteger('to_status')->default(0);
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
      Schema::dropIfExists('task_status_history');
    }
  }
