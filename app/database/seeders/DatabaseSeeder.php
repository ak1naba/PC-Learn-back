<?php

namespace Database\Seeders;

use App\Models\Progress;
use App\Models\Status;
use App\Models\TypeLesson;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin_pass',
            'role' => 1,
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'user_pass',
            'role' => 2,
        ]);

        TypeLesson::create([
            'id'=>'1',
            'type' => 'theory'
        ]);
        TypeLesson::create([
            'id'=>'2',
            'type' => 'practic'
        ]);

        Status::create([
            'id'=>'1',
            'status' => 'not done'
        ]);
        Status::create([
            'id'=>'2',
            'status' => 'done'
        ]);
    }
}
