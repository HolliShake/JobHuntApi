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
        Schema::table('job_classification', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->integer('slots');

            $table->unsignedBigInteger('salary_id');
            $table->foreign('salary_id')->references('id')->on('salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
