<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Administrateur Principal',
                'email' => 'admin@ecovert.local',
                'password' => Hash::make('admin123'),
                'permission_level' => 'superadmin',
            ],
            [
                'name' => 'Administrateur Support',
                'email' => 'support@ecovert.local',
                'password' => Hash::make('support123'),
                'permission_level' => 'editor',
            ],
            [
                'name' => 'Administrateur Modérateur',
                'email' => 'moderator@ecovert.local',
                'password' => Hash::make('moderator123'),
                'permission_level' => 'viewer',
            ],
        ];

        foreach ($admins as $adminData) {
            $permissionLevel = $adminData['permission_level'];
            unset($adminData['permission_level']);

            $adminUser = User::firstOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'password' => $adminData['password'],
                    'role' => 'admin',
                    'country' => 'Sénégal',
                    'is_active' => true,
                ]
            );

            Admin::firstOrCreate(
                ['user_id' => $adminUser->id],
                [
                    'permission_level' => $permissionLevel,
                ]
            );

            $this->command->info("Admin créé : {$adminData['email']}");
        }
    }
}
