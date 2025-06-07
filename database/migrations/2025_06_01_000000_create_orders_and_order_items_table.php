<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersAndOrderItemsTable extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name');
            $table->string('last_name');
            $table->string('document');
            $table->string('country_code', 3);
            $table->string('state_code', 2)->nullable();
            $table->string('postal_code', 8);
            $table->string('city');
            $table->string('address');
            $table->string('complement')->nullable();
            $table->string('phone');
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('book');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}
