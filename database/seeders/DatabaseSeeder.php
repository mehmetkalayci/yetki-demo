<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\PermissionAndGroupSeeder;
use Database\Seeders\ModelPermissionSeeder;
use Database\Seeders\PermissionGroupSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // İzin gruplarını seed et
        $this->call(PermissionGroupSeeder::class);

        // Rolleri seed et
        $this->call(RoleSeeder::class);

        // İzinleri seed et
        $this->call(PermissionAndGroupSeeder::class);

        // Kullanıcıları seed et
        $this->call(UserSeeder::class);
    }
}
