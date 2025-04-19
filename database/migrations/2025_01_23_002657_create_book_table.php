<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('author')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('category')->cascadeOnDelete();
            $table->string('title')->unique();
            $table->string('summary', 500);
            $table->text('abstract');
            $table->decimal('price');
            $table->integer('total_pages');
            $table->string('book_identifier')->unique();
            $table->date('publication_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book');
    }
};
