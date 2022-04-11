<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $authorRole = Role::where('name', 'author')->first();

        User::truncate();

        $admin = User::create([
            'name' => 'Kimheang',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $joe = User::create([
            'name' => 'Joe',
            'username' => 'joe',
            'email' => 'joe@joe.com',
            'password' => Hash::make('password')
        ]);

        $admin->roles()->attach($adminRole);
        $joe->roles()->attach($authorRole);
    }
}
