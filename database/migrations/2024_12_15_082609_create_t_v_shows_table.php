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
        Schema::create('t_v_shows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('poster_url')->nullable();
            $table->date('release_date')->nullable(); // Kept as date
            $table->json('categories')->nullable();
            $table->float('rating')->nullable();
            $table->text('overview')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->string('category')->nullable(); // Made nullable, as not all shows may have a category
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_shows');
    }
};
