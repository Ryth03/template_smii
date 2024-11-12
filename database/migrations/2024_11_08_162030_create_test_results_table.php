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
        Schema::create('testResults', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->float('lel');
            $table->float('o2');
            $table->float('h2s');
            $table->float('co');
            $table->date('test_date');
            $table->timestamps();  
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testResults');
    }
};
