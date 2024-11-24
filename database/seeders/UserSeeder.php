<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Rolleri al
        $roles = Role::all();

        // Kullanıcıları oluştur
        $users = [
            [
                'name' => 'Ahmet Yılmaz',
                'email' => 'ahmet.yilmaz@example.com',
                'password' => Hash::make('password123'),
                'role' => 'süper-admin',
                'permissions' => [1, 2, 3, 4, 5, 17], // Tüm izinler
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 1, 'permission_id' => 1],
                    ['model_type' => 'App\Models\Device', 'model_id' => 2, 'permission_id' => 2],
                ],
            ],
            [
                'name' => 'Mehmet Demir',
                'email' => 'mehmet.demir@example.com',
                'password' => Hash::make('password123'),
                'role' => 'yönetici',
                'permissions' => [1, 2, 5], // Cihaz ekleme, düzenleme, rapor görüntüleme
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 3, 'permission_id' => 2],
                    ['model_type' => 'App\Models\Hospital', 'model_id' => 1, 'permission_id' => 1],
                ],
            ],
            [
                'name' => 'Ayşe Kaya',
                'email' => 'ayse.kaya@example.com',
                'password' => Hash::make('password123'),
                'role' => 'teknisyen',
                'permissions' => [3, 4], // Cihaz görüntüleme ve silme
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 4, 'permission_id' => 3],
                    ['model_type' => 'App\Models\Hospital', 'model_id' => 2, 'permission_id' => 1],
                ],
            ],
            [
                'name' => 'Fatma Çelik',
                'email' => 'fatma.celik@example.com',
                'password' => Hash::make('password123'),
                'role' => 'doktor',
                'permissions' => [5, 6], // Rapor görüntüleme ve oluşturma
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 5, 'permission_id' => 4],
                    ['model_type' => 'App\Models\Report', 'model_id' => 1, 'permission_id' => 5],
                ],
            ],
            [
                'name' => 'Ali Koç',
                'email' => 'ali.koc@example.com',
                'password' => Hash::make('password123'),
                'role' => 'hasta',
                'permissions' => [], // İzin yok
                'model_permissions' => [],
            ],
            [
                'name' => 'Zeynep Arslan',
                'email' => 'zeynep.arslan@example.com',
                'password' => Hash::make('password123'),
                'role' => 'yönetici',
                'permissions' => [1, 3], // Cihaz ekleme ve görüntüleme
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 6, 'permission_id' => 1],
                    ['model_type' => 'App\Models\Hospital', 'model_id' => 3, 'permission_id' => 2],
                ],
            ],
            [
                'name' => 'Emre Yıldız',
                'email' => 'emre.yildiz@example.com',
                'password' => Hash::make('password123'),
                'role' => 'teknisyen',
                'permissions' => [2, 4], // Cihaz düzenleme ve silme
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 7, 'permission_id' => 2],
                    ['model_type' => 'App\Models\Report', 'model_id' => 2, 'permission_id' => 3],
                ],
            ],
            [
                'name' => 'Burcu Demirtaş',
                'email' => 'burcu.demirtas@example.com',
                'password' => Hash::make('password123'),
                'role' => 'doktor',
                'permissions' => [5], // Rapor görüntüleme
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 8, 'permission_id' => 3],
                    ['model_type' => 'App\Models\Report', 'model_id' => 3, 'permission_id' => 5],
                ],
            ],
            [
                'name' => 'Canan Korkmaz',
                'email' => 'canan.korkmaz@example.com',
                'password' => Hash::make('password123'),
                'role' => 'hasta',
                'permissions' => [], // İzin yok
                'model_permissions' => [],
            ],
            [
                'name' => 'Oğuzhan Çetin',
                'email' => 'oguzhan.cetin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'rapor-yetkilisi',
                'permissions' => [6], // Rapor oluşturma
                'model_permissions' => [
                    ['model_type' => 'App\Models\Device', 'model_id' => 9, 'permission_id' => 4],
                    ['model_type' => 'App\Models\Report', 'model_id' => 4, 'permission_id' => 5],
                ],
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            // Kullanıcıya rol ata
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }

            // Kullanıcıya izinleri ata
            if (!empty($userData['permissions'])) {
                $user->permissions()->attach($userData['permissions']);
            }

            // Model izinlerini ata
            foreach ($userData['model_permissions'] as $modelPermission) {
                $user->modelPermissions()->create($modelPermission);
            }
        }
    }
}