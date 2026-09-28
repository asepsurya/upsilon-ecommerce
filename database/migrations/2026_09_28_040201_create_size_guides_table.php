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
        Schema::create('size_guides', function (Blueprint $table) {
            $table->id();
            $table->string('size_label');
            $table->string('size_type')->default('tshirt');
            $table->string('chest_cm')->nullable();
            $table->string('chest_inch')->nullable();
            $table->string('waist_cm')->nullable();
            $table->string('waist_inch')->nullable();
            $table->string('hip_cm')->nullable();
            $table->string('hip_inch')->nullable();
            $table->string('shoulder_cm')->nullable();
            $table->string('sleeve_length_cm')->nullable();
            $table->string('body_length_cm')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_guides');
    }
};
