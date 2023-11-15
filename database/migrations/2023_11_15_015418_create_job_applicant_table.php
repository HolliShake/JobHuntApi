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
        Schema::create('job_applicant', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('application_date');
            $table->enum('status', ['pending', 'accepted', 'rejected']);

            // Fk
            $table->unsignedBigInteger('job_posting_id');
            $table->foreign('job_posting_id')->references('id')->on('job_posting');
            // FK
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applicant');
    }
};
