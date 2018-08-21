<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('points')->default(1);
            $table->smallInteger('priority')->default(1);
            $table->string('link')->nullable();
            $table->text('files')->nullable();
            $table->boolean('done')->default('0');
            $table->timestamp('due_date')->nullable();
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
        Schema::dropIfExists('subtasks');
    }
}
