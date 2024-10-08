<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignid('user_id')->constrained()->cascadeOnDelete()->nullable();
            $table->date('work_date')->nullable();
            $table->integer('work_start');
            $table->integer('work_end')->nullable();
            $table->integer('work_time')->nullable();
            $table->integer('allbreaking_time')->nullable();
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
        Schema::dropIfExists('works');
    }
}
