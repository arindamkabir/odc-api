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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('categories');
            $table->longText('description');
            $table->decimal('price')->unsigned();
            $table->decimal('sales_price')->nullable()->unsigned();
            $table->string('SKU')->unique();
            $table->boolean('has_colors');
            $table->boolean('has_sizes');
            $table->boolean('is_hidden');
            $table->boolean('is_featured');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
