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
        Schema::create('file_sample_photo', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('file_name');
            //Fk
            $table->unsignedBigInteger('job_posting_id');
            $table->foreign('job_posting_id')->references('id')->on('job_posting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_sample_photo');
    }
};
