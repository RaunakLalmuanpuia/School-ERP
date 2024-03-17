<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
        ]);

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
        ]);

        // Assign the admin role
        $adminRole = Role::where('name', 'admin')->first();

        $user->assignRole($adminRole);
    }
}
