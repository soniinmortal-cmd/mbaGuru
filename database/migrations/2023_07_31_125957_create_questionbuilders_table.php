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
        Schema::create('questionbuilders', function (Blueprint $table) {
            $table->id();
            $table->string('test_id')->nullable();
            $table->string('question_type')->nullable();
            $table->string('paper_type')->nullable();
            $table->string('question')->nullable();
            $table->string('answer')->nullable();
            $table->string('percentage')->nullable();
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
        Schema::dropIfExists('questionbuilders');
    }
};
