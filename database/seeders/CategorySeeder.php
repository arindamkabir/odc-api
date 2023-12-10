<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Tops', 'slug' => Str::slug('tops'), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Pants', 'slug' => Str::slug('pants'), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Jackets', 'slug' => Str::slug('jackets'), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Tops', 'slug' => Str::slug('tops'), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Pants', 'slug' => Str::slug('pants'), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Jackets', 'slug' => Str::slug('jackets'), 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}
