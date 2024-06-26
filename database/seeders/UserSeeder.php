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
            'email' => 'admin.ct@ppa-inka.com',
            'password' => bcrypt('1500vdcON*'),
        ]);

        $admin->assignRole('admin');
    

     $user = User::create([
            'name' => 'User',
            'email' => 'usercentral@gmail.com',
            'password' => bcrypt('1500vdcON*'),
        ]);

        $user->assignRole('user');
    }
}
