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
        Schema::table('personal_data', function(Blueprint $table) {
            $table->string('address')->nullable()->change();
            $table->integer('postal')->nullable()->change();
            $table->string('municipality')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('religion')->nullable()->change();
            $table->string('civil_status')->nullable()->change();
            $table->string('citizenship')->nullable()->change();

            // Mother
            $table->string('mother_first_name')->nullable()->change();
            $table->string('mother_middle_name')->nullable()->change();
            $table->string('mother_last_name')->nullable()->change();

            // Father
            $table->string('father_first_name')->nullable()->change();
            $table->string('father_middle_name')->nullable()->change();
            $table->string('father_last_name')->nullable()->change();
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
