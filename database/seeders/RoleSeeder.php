<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Define roles
         $roles = [
            'admin',
            'teacher',
            'student',
        ];
         // Create roles
         foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}
