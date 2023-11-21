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
        Schema::table('educational_attainment', function (Blueprint $table) {
            $table->unsignedBigInteger('personal_data_id')->after('description');
            $table->foreign('personal_data_id')->references('id')->on('personal_data');
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
