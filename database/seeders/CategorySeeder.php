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
            ['name' => 'Womens', 'slug' => Str::slug('Womens'), 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Mens', 'slug' => Str::slug('Mens'), 'created_at' => date('Y-m-d H:i:s')],
        ]);

        DB::table('categories')->insert([
            ['name' => 'Tops', 'slug' => Str::slug('tops'), 'parent_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Pants', 'slug' => Str::slug('pants'), 'parent_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Jackets', 'slug' => Str::slug('jackets'), 'parent_id' => 1, 'created_at' => date('Y-m-d H:i:s')],


            ['name' => 'Tops', 'slug' => Str::slug('tops'), 'parent_id' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Pants', 'slug' => Str::slug('pants'), 'parent_id' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Jackets', 'slug' => Str::slug('jackets'), 'parent_id' => 2, 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}
