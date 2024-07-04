<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\Admin;
use Modules\Auth\Models\User;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'JohnDoe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        Admin::factory()->create([
            'username' => 'admin',
            'email' => 'admin@next-tube.com',
            'password' => Hash::make('password'),
        ]);
    }
}
