<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Conference;
use App\Models\Talk;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Asadh Shujau',
            'email' => 'shujau@laraconf.com',
        ]);

        User::factory(19)->create();

        Conference::factory(200)->create();

        Talk::factory(200)->create();
    }
}
