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
        Schema::create('excel_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('test_id');
            $table->integer('serial_no')->nullable();
            $table->string('section_name');
            $table->string('tag');
            $table->string('positive_mark');
            $table->string('negative_mark');
            $table->string('level');
            $table->string('answer_time');
            $table->string('instruction');
            $table->string('answer_explanation');
            $table->string('question');
            $table->string('question_type');
            $table->string('correct_option');
            $table->string('option1')->nullable();
            $table->string('option2')->nullable();
            $table->string('option3')->nullable();
            $table->string('option4')->nullable();
            $table->string('option5')->nullable();
            $table->string('criteria1')->nullable();
            $table->string('percentage1')->nullable();
            $table->string('criteria2')->nullable();
            $table->string('percentage2')->nullable();
            $table->string('criteria3')->nullable();
            $table->string('percentage3')->nullable();
            $table->string('criteria4')->nullable();
            $table->string('percentage4')->nullable();
             $table->string('criteria5')->nullable();
            $table->string('percentage5')->nullable();
            $table->string('answer')->nullable();
            $table->string('video_link')->nullable();
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
        Schema::dropIfExists('excel_questions');
    }
};
