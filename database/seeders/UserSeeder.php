<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@role.test',
            'password' => bcrypt('12345'),
        ]);

        $admin->assignRole('admin');


        $user = User::create([
            'name' => 'User',
            'email' => 'user@role.test',
            'password' => bcrypt('12345'),
        ]);

        $user->assignRole('user');
    }
}
