<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RolesAndPermissionsSeeder::class);
        $user=User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=>Hash::make('Password2023!'),
        ]);
        $user->assignRole('admin');
    }
}
