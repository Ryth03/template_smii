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
        Schema::create('extended_form_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->date('start_date_before');
            $table->date('end_date_before');
            $table->date('start_date_after');
            $table->date('end_date_after');
            $table->string('status');
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extended_form_logs');
    }
};
