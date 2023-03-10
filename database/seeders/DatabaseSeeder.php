<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $user->grades()->saveMany(\App\Models\Grade::factory(3)->create([
                'user_id' => $user->id
            ]));
        });;

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin'
        ]);

        $student = \App\Models\User::factory()->create([
            'name' => 'student User',
            'email' => 'student@example.com',
            'role' => 'student'
        ]);

        $student->grades()->saveMany(\App\Models\Grade::factory(3)->create([
            'user_id' => $student->id
        ]));
    }
}
