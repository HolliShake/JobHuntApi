<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('application_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //
            $table->dateTime('event_date')->default(Date::now());
            $table->string('event_title');
            $table->string('event_description');
            $table->unsignedInteger('score')->default(0);
            // Fk Application
            $table->unsignedBigInteger('job_applicant');
            $table->foreign('job_applicant')->references('id')->on('job_applicant');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_logs');
    }
};
