<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->insert([
            ['code' => 'EXPIRED', 'min_cart_value' => 1000, 'value' => 10, 'value_type' => 'percentage', 'max_value' => 100, 'redemptions' => 5, 'expiry_date' => Carbon::now()->subWeek()],
            ['code' => 'CHEAPSKATE125', 'min_cart_value' => 1000, 'value' => 10, 'value_type' => 'fixed', 'max_value' => 100, 'redemptions' => 5, 'expiry_date' => Carbon::now()->addWeek()],
            ['code' => 'CHEAPSKATE124', 'min_cart_value' => 1000, 'value' => 20, 'value_type' => 'percentage', 'max_value' => 100, 'redemptions' => 5, 'expiry_date' => Carbon::now()->addWeek()],
        ]);
    }
}

// $table->string('code');
// $table->decimal('min_cart_value');
// $table->decimal('value');
// $table->enum('value_type', ['fixed', 'percentage']);
// $table->decimal('max_value')->nullable();
// $table->boolean('is_disabled')->default(false);
// $table->integer('redemptions');
// $table->dateTime('expiry_date');
