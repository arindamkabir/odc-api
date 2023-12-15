<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::factory()->create();

        DB::table('users')->insert([
            'name' => 'Arindam Kabir',
            'email' => 'arindamkabir@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'userable_type' => 'App\Models\Admin',
            'userable_id' => $admin->id
        ]);

        $admin2 = Admin::factory()->create();

        DB::table('users')->insert([
            'name' => 'Hiroki Ahamed',
            'email' => 'hiroki.ext11@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'userable_type' => 'App\Models\Admin',
            'userable_id' => $admin->id
        ]);
    }
}
