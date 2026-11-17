<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =[
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'role' => 'admin'],
        ];
            
        foreach ($users as $user) {
        User::firstOrCreate(
            ['email' => $user['email']],
            [
                'name'     => $user['name'],
                'password' => bcrypt('password123'),
                'role'     => $user['role'],
            ]
        );
    }

        }
            }
