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
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('address');
            $table->integer('postal');
            $table->string('municipality');
            $table->string('city');
            $table->string('religion');
            $table->string('civil_status');
            $table->string('citizenship');

            // Mother
            $table->string('mother_first_name');
            $table->string('mother_maiden_name');
            $table->string('mother_last_name');

            // Father
            $table->string('father_first_name');
            $table->string('father_middle_name');
            $table->string('father_last_name');

            // Fk
            $table->unsignedBigInteger('user_id');
            $table->foreign(('user_id'))->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_data');
    }
};
