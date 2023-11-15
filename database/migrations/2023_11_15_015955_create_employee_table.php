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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('employeeID');
            // Add more fields later
            // Fk
            $table->unsignedBigInteger('hired_applicant_id');
            $table->foreign('hired_applicant_id')->references('id')->on('hired_applicant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
