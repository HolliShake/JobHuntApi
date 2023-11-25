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
        Schema::create('position', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->integer('slots');
            $table->string('description');
            $table->enum('employment_type', [ 'Full-Time', 'Part-Time', 'Job Order', 'Contractual', 'Casual' ]);
            $table->string('skills');
            //
            $table->unsignedBigInteger('salary_id');
            $table->foreign('salary_id')->references('id')->on('salary');
            //
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position');
    }
};
