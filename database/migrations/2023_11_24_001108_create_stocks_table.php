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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('size_id')
                ->nullable()
                ->constrained('sizes');
            $table->foreignId('color_id')
                ->nullable()
                ->constrained('colors');
            $table->integer('quantity')
                ->unsigned();
            $table->decimal('price')->unsigned();
            $table->decimal('sales_price')->nullable()->unsigned();
            $table->unique(['product_id', 'size_id', 'color_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
