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
        Schema::create('fitToWork', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('worker_name');
            $table->boolean('ok');
            $table->boolean('not_ok');
            $table->boolean('clinic_check');
            $table->string('clinic_recomendation')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();  
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitToWork');
    }
};
