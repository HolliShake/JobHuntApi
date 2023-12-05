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
        Schema::table('job_applicant', function(Blueprint $table) {
            $table->dropForeign(['recruiter_id']);
            $table->dropColumn('recruiter_id');
            //
            $table->dateTime('application_date')->default(Date::now())->change();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->change();
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
