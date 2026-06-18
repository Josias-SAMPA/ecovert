<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appeler les seeders
        $this->call([
            AdminSeeder::class,
            PartnerSeeder::class,
        ]);

        // Créer 15 utilisateurs de test
        $users = [
            ['name' => 'Amadou Sow', 'email' => 'amadou.sow@farmers.local', 'country' => 'Sénégal'],
            ['name' => 'Fatoumata Ba', 'email' => 'fatoumata.ba@farmers.local', 'country' => 'Mali'],
            ['name' => 'Ibrahim Traore', 'email' => 'ibrahim.traore@farmers.local', 'country' => 'Burkina Faso'],
            ['name' => 'Mariam Diallo', 'email' => 'mariam.diallo@farmers.local', 'country' => 'Côte d\'Ivoire'],
            ['name' => 'Moussa Cissé', 'email' => 'moussa.cisse@farmers.local', 'country' => 'Guinée'],
            ['name' => 'Awa Ndiaye', 'email' => 'awa.ndiaye@farmers.local', 'country' => 'Sénégal'],
            ['name' => 'Ousmane Kante', 'email' => 'ousmane.kante@farmers.local', 'country' => 'Mali'],
            ['name' => 'Hawa Diop', 'email' => 'hawa.diop@farmers.local', 'country' => 'Sénégal'],
            ['name' => 'Seydou Diallo', 'email' => 'seydou.diallo@farmers.local', 'country' => 'Guinée-Bissau'],
            ['name' => 'Aïssatou Ba', 'email' => 'aissatou.ba@farmers.local', 'country' => 'Niger'],
            ['name' => 'Lamine Gueye', 'email' => 'lamine.gueye@farmers.local', 'country' => 'Sénégal'],
            ['name' => 'Yacine Faye', 'email' => 'yacine.faye@farmers.local', 'country' => 'Sénégal'],
            ['name' => 'Oumou Sanogo', 'email' => 'oumou.sanogo@farmers.local', 'country' => 'Mali'],
            ['name' => 'Abdoulaye Sall', 'email' => 'abdoulaye.sall@farmers.local', 'country' => 'Sénégal'],
            ['name' => 'Mariama Toure', 'email' => 'mariama.toure@farmers.local', 'country' => 'Liberia'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('user123'),
                    'role' => 'user',
                    'country' => $userData['country'],
                    'is_active' => true,
                ]
            );

            $this->command->info("Utilisateur créé : {$userData['email']}");
        }

        $this->command->info('✅ Tous les seeders ont été exécutés avec succès !');
    }
}
