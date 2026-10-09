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
        Schema::create('test_templatevalues', function (Blueprint $table) {
            $table->id();
            $table->string('temp_id');
            $table->string('total_marks')->nullable();
            $table->string('exam_duration')->nullable();
            $table->string('total_question')->nullable();
            $table->string('total_question_type')->nullable();
            $table->string('total_section')->nullable();
            $table->string('section_duration')->nullable();
            $table->string('calculator_type')->nullable();
            $table->string('exame_instruction')->nullable();
            $table->string('section_order_selection')->nullable();
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
        Schema::dropIfExists('test_templatevalues');
    }
};
