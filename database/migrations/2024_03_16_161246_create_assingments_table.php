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
        Schema::create('assingments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('subjects_id')->nullable();

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('due_date')->nullable();
            $table->text('file')->nullable();
            $table->date('acadamic_year')->nullable();

            $table->foreign('subjects_id')->references('id')->on('subjects');
         


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
        Schema::dropIfExists('assingments');
    }
};
