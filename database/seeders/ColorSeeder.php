<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            ['name' => 'Black', 'hex_code' => '#000000', 'slug' => Str::slug('Black')],
            ['name' => 'Red', 'hex_code' => '#ef4444', 'slug' => Str::slug('Red')],
            ['name' => 'Aqua', 'hex_code' => '#06b6d4', 'slug' => Str::slug('Aqua')],
            ['name' => 'Green', 'hex_code' => '#22c55e', 'slug' => Str::slug('Green')],
        ]);
    }
}
