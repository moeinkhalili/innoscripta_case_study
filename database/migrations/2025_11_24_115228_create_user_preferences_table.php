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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('preferred_author_id')->nullable();
            $table->unsignedBigInteger('preferred_category_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('preferred_author_id')->references('id')->on('authors')->cascadeOnDelete();
            $table->foreign('preferred_category_id')->references('id')->on('categories')->cascadeOnDelete();

            $table->unique(['user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
