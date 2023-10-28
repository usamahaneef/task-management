<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Overides\Permission;
use App\Models\Task;
use App\Models\University;
use App\Models\Venue;
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
        $this->call([AdminUsersTableSeeder::class]);
        $this->call([TaskTableSeeder::class]);
    }
}
