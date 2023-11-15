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
        Schema::create('hired_applicant', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('hired_date');
            // Fk
            $table->unsignedBigInteger('job_applicant_id');
            $table->foreign('job_applicant_id')->references('id')->on('job_applicant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hired_applicant');
    }
};
