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
        Schema::create('publish_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('test_id')->nullable();
            $table->string('course_id')->nullable();
            $table->string('status')->nullable();
            $table->string('start_date')->nullable();
             $table->string('end_date')->nullable();
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
        Schema::dropIfExists('publish_statuses');
    }
};
