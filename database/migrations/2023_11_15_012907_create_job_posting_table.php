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
        Schema::create('job_posting', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('description');
            $table->dateTime('date_posted');
            $table->dateTime('date_until');

            // Fk
            $table->unsignedBigInteger('job_classification_id');
            $table->foreign('job_classification_id')->references('id')->on('job_classification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posting');
    }
};
