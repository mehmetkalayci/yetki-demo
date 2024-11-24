<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'süper-admin']);
        Role::create(['name' => 'yönetici']);
        Role::create(['name' => 'teknisyen']);
        Role::create(['name' => 'doktor']);
        Role::create(['name' => 'hasta']);
        Role::create(['name' => 'rapor-yetkilisi']);
    }
}