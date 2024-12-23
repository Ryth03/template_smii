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
        Schema::create('extended_files_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('extended_id');
            $table->unsignedBigInteger('form_id');
            $table->string('type');
            $table->string('file_location');
            $table->json('file_name_before')->nullable();
            $table->json('file_name_after');
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('extended_id')->references('id')->on('extended_form_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extended_files_logs');
    }
};
