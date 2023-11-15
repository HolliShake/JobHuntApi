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
        Schema::create('educational_attainment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('school_name');
            $table->string('location');
            $table->dateTime('start_sy');
            $table->dateTime('end_sy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_attainment');
    }
};
