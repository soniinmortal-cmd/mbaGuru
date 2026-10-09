<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_durations', function (Blueprint $table) {
            $table->id();
            $table->integer('test_id');
            $table->string('duration');
            $table->string('all_duration');
            $table->string('verbal_time');
            $table->string('interp_time');
            $table->string('quantitative_time');
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
        Schema::dropIfExists('quiz_durations');
    }
};
