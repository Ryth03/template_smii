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
        Schema::create('personalProtectiveEquipment_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('master_id');
            $table->timestamps();  
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('master_id')->references('id')->on('personalProtectiveEquipment_master')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalProtectiveEquipment_data');
    }
};
