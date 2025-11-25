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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->longText('body');
            $table->text('url');
            $table->text('thumbnail')->nullable();
            $table->timestamp('published_at')->index();
            $table->string('provider');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('author_id')->references('id')->on('authors')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();

            $table->index(['author_id', 'category_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
