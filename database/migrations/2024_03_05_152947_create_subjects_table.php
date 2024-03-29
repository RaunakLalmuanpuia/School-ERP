<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();

            $table->string('name')->nullable();
            $table->string('subject_code')->nullable();
            $table->date('acadamic_year')->nullable();

            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('teacher_id')->references('id')->on('teachers');

            $table->string('param1')->nullable();
            $table->string('param2')->nullable();
            $table->string('param3')->nullable();
            $table->string('param4')->nullable();
            $table->string('param5')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};



