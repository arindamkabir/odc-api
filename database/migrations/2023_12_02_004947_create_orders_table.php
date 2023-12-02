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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->decimal('subtotal')->unsigned();
            $table->decimal('discount')->default(0)->unsigned();
            $table->decimal('tax')->default(0)->unsigned();
            $table->decimal('total')->unsigned();
            $table->boolean('is_billing_different')->default(false);
            $table->date('shipped_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('return_reason')->nullable();
            $table->enum('status', ['placed', 'paid', 'shipped', 'delivered', 'cancelled', 'returned'])->default('placed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
