<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionGroup;

class PermissionGroupSeeder extends Seeder
{
    public function run(): void
    {
        PermissionGroup::create(['name' => 'Cihaz Yönetimi', 'description' => 'Cihazlarla ilgili izinler']);
        PermissionGroup::create(['name' => 'Rapor Yönetimi', 'description' => 'Raporlarla ilgili izinler']);
        PermissionGroup::create(['name' => 'Kullanıcı Yönetimi', 'description' => 'Kullanıcılarla ilgili izinler']);
        PermissionGroup::create(['name' => 'Rol Yönetimi', 'description' => 'Rollerle ilgili izinler']);
        PermissionGroup::create(['name' => 'Ayar Yönetimi', 'description' => 'Uygulama ayarları ile ilgili izinler']);
    }
}