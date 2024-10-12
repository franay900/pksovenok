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
        Schema::create('bell_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('day');
            $table->integer('number');
            $table->string('begin');
            $table->string('end');
            $table->unsignedBigInteger('bell_id');
            $table->foreign('bell_id')->references('id')->on('bells');
            $table->index('bell_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bell_lessons');
    }
};
