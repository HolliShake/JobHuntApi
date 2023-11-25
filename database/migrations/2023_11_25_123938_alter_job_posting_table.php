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
        Schema::table('job_posting', function(Blueprint $table) {
            $table->dropForeign(['job_classification_id']);
            $table->dropColumn('job_classification_id');
            // Fk
            $table->unsignedBigInteger('adtype_id')->after('date_posted');
            $table->foreign('adtype_id')->references('id')->on('adtype');
            // Fk
            $table->unsignedBigInteger('position_id')->after('adtype_id');
            $table->foreign('position_id')->references('id')->on('position');
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
