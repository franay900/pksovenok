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
        Schema::create('timetable_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_id')->constrained();
            $table->unsignedInteger('day');
            $table->unsignedInteger('number');
            $table->foreignId('timetable_id')->constrained();
            $table->foreignId('group_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable_lessons');
    }
};
