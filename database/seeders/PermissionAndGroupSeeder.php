<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionAndGroupSeeder extends Seeder
{
    public function run(): void
    {
        // Cihaz Yönetimi İzinleri
        Permission::create(['name' => 'cihaz-ekle', 'display_name' => 'Cihaz Ekle', 'permission_group_id' => 1]);
        Permission::create(['name' => 'cihaz-düzenle', 'display_name' => 'Cihaz Düzenle', 'permission_group_id' => 1]);
        Permission::create(['name' => 'cihaz-görüntüle', 'display_name' => 'Cihaz Görüntüle', 'permission_group_id' => 1]);
        Permission::create(['name' => 'cihaz-sil', 'display_name' => 'Cihaz Sil', 'permission_group_id' => 1]);

        // Rapor Yönetimi İzinleri
        Permission::create(['name' => 'rapor-görüntüle', 'display_name' => 'Rapor Görüntüle', 'permission_group_id' => 2]);
        Permission::create(['name' => 'rapor-oluştur', 'display_name' => 'Rapor Oluştur', 'permission_group_id' => 2]);
        Permission::create(['name' => 'rapor-düzenle', 'display_name' => 'Rapor Düzenle', 'permission_group_id' => 2]);
        Permission::create(['name' => 'rapor-sil', 'display_name' => 'Rapor Sil', 'permission_group_id' => 2]);

        // Kullanıcı Yönetimi İzinleri
        Permission::create(['name' => 'kullanici-ekle', 'display_name' => 'Kullanıcı Ekle', 'permission_group_id' => 3]);
        Permission::create(['name' => 'kullanici-düzenle', 'display_name' => 'Kullanıcı Düzenle', 'permission_group_id' => 3]);
        Permission::create(['name' => 'kullanici-görüntüle', 'display_name' => 'Kullanıcı Görüntüle', 'permission_group_id' => 3]);
        Permission::create(['name' => 'kullanici-sil', 'display_name' => 'Kullanıcı Sil', 'permission_group_id' => 3]);

        // Rol Yönetimi İzinleri
        Permission::create(['name' => 'rol-ekle', 'display_name' => 'Rol Ekle', 'permission_group_id' => 4]);
        Permission::create(['name' => 'rol-düzenle', 'display_name' => 'Rol Düzenle', 'permission_group_id' => 4]);
        Permission::create(['name' => 'rol-görüntüle', 'display_name' => 'Rol Görüntüle', 'permission_group_id' => 4]);
        Permission::create(['name' => 'rol-sil', 'display_name' => 'Rol Sil', 'permission_group_id' => 4]);

        // Ayar Yönetimi İzni
        Permission::create(['name' => 'ayarları-yönet', 'display_name' => 'Ayarları Yönet', 'permission_group_id' => 5]);
    }
}