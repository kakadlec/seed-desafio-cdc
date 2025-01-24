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
        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->integer('author');
            $table->integer('category');
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

    /**
     *
     * 'author' => 'required',
     * 'category' => 'required',
     * 'title' => 'required|string|unique',
     * 'summary' => 'required|string|max:500',
     * '$abstract' => 'string',
     * '$price' => 'integer|min:20',
     * 'totalPages' => 'integer|min:100',
     * 'bookIdentifier' => 'string|unique',
     * 'pubDate' => 'date_format:Y-m-d|after:now',
     *
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book');
    }
};
