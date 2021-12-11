<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(10)->create();
        \App\Models\Ticket::factory(50)->create();
        \App\Models\Review::factory(100)->create();
        \App\Models\Image::factory(100)->create();
        \App\Models\Like::factory(100)->create();
    }
}
