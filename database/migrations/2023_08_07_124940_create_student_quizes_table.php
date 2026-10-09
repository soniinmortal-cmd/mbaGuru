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
        Schema::create('student_quizes', function (Blueprint $table) {
            $table->id();
            $table->string('test_id');
            $table->string('user_id')->nullable();
            $table->string('section_type');
            $table->string('paper_id');
            $table->string('student_duration');
            $table->string('ans_duration');
            $table->string('question_type')->nullable();
            $table->string('question_id')->nullable();
            $table->string('level')->nullable();
            $table->string('answer')->nullable();
            $table->string('set_type')->nullable();
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
        Schema::dropIfExists('student_quizes');
    }
};
