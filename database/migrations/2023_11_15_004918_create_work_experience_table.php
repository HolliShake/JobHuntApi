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
        Schema::create('work_experience', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('company_name');
            $table->string('company_location');
            $table->string('company_email');
            $table->string('position_or_role');
            $table->dateTime('startDate');
            $table->dateTime('endDate')->nullable();
            // Fk
            $table->unsignedBigInteger('personal_data_id');
            $table->foreign('personal_data_id')->references('id')->on('personal_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experience');
    }
};
