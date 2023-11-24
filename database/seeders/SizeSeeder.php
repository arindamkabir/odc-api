<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            ['name' => 'xs', 'slug' => Str::slug('xs')],
            ['name' => 'sm', 'slug' => Str::slug('sm')],
            ['name' => 'md', 'slug' => Str::slug('md')],
            ['name' => 'xl', 'slug' => Str::slug('xl')],
        ]);
    }
}
