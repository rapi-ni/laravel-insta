<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'          => 'luffy',
            'email'         => 'luffy@gmail.com',
            'password'      => Hash::make('luffy12345'),
            'role_id'       => 2
        ]);
        User::create([
            'name'          => 'zoro',
            'email'         => 'zoro@gmail.com',
            'password'      => Hash::make('zoro12345'),
            'role_id'       => 2
        ]);
        User::create([
            'name'          => 'sanji',
            'email'         => 'sanji@gmail.com',
            'password'      => Hash::make('sanji12345'),
            'role_id'       => 2
        ]);
        User::create([
            'name'          => 'chopper',
            'email'         => 'chopper@gmail.com',
            'password'      => Hash::make('chopper12345'),
            'role_id'       => 2
        ]);
        User::create([
            'name'          => 'brock',
            'email'         => 'brock@gmail.com',
            'password'      => Hash::make('brock12345'),
            'role_id'       => 2
        ]);
    }
}
