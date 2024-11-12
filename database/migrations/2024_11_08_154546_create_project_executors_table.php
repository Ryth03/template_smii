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
        Schema::create('project_executors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('company_department');
            $table->string('hp_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('supervisor');
            $table->string('location');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('workers_count');
            $table->text('work_description');
            $table->timestamps();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_executors');
    }
};
