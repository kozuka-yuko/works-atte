<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakings', function (Blueprint $table) {
            $table->id();
            $table->foreignid('work_id')->constrained()->cascadeOnDelete();
            $table->string('breaking_start');
            $table->string('breaking_end')->nullable();
            $table->string('breaking_time')->nullable();
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
        Schema::dropIfExists('breakings');
    }
}
