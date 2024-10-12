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
        Schema::create('periods', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('period_type_id');
            $table->index('period_type_id');
            $table->foreign('period_type_id')->references('id')->on('period_types');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->index('organization_id')->nullable();
            $table->string('begin');
            $table->string('end');
            $table->index('year_id');
            $table->foreign('year_id')->references('id')->on('years');
            $table->integer('number');
            $table->timestamps();
 
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
