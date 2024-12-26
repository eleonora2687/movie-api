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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('poster_url')->nullable();
            $table->date('release_date')->nullable(); // Changed to 'date' type
            $table->json('categories')->nullable();
            $table->string('duration')->nullable();
            $table->float('rating')->nullable();
            $table->text('overview')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->string('category')->nullable(); // Kept nullable
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
