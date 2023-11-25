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
        Schema::create('adtype', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->decimal('price', 19, 2); // 8 digits, 2
            $table->dateTime('post_date');
            $table->unsignedInteger('duration'); // in days
            $table->unsignedInteger('max_skills_matching')->min(1)->max(1000)->default(2);
            //
            $table->boolean('is_search_priority')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_analytics_available')->default(false);
            $table->boolean('is_editable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adtype');
    }
};
