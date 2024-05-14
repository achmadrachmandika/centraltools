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
            'email' => 'admincentraltoolsppa@gmail.com',
            'password' => bcrypt('PPACentralTools*6'),
        ]);

        $admin->assignRole('admin');
    

     $user = User::create([
            'name' => 'User',
            'email' => 'usercentral@gmail.com',
            'password' => bcrypt('CentralTools*6'),
        ]);

        $user->assignRole('user');
    }
}
