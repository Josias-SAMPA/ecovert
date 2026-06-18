<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            ['name' => 'Coopérative Agricole du Delta', 'company' => 'CAD Sénégal', 'type' => 'institutional', 'country' => 'Sénégal'],
            ['name' => 'Météo Services Africa', 'company' => 'MSA Tech', 'type' => 'technical', 'country' => 'Côte d\'Ivoire'],
            ['name' => 'Fondation pour le Développement Rural', 'company' => 'FDR Mali', 'type' => 'institutional', 'country' => 'Mali'],
            ['name' => 'Digital Solutions Burkina', 'company' => 'DSB Solutions', 'type' => 'technical', 'country' => 'Burkina Faso'],
            ['name' => 'Investissements Agricoles Durables', 'company' => 'IAD Capital', 'type' => 'investor', 'country' => 'Bénin'],
            ['name' => 'Association des Éleveurs du Sahel', 'company' => 'AES Niger', 'type' => 'institutional', 'country' => 'Niger'],
            ['name' => 'Tech for Agriculture', 'company' => 'TFA Innovation', 'type' => 'technical', 'country' => 'Togo'],
            ['name' => 'Fonds Vert d\'Afrique', 'company' => 'FVA Invest', 'type' => 'investor', 'country' => 'Guinée'],
            ['name' => 'Réseau des Producteurs Locaux', 'company' => 'RPL Guinée-Bissau', 'type' => 'institutional', 'country' => 'Guinée-Bissau'],
            ['name' => 'Solutions Météo Intégrées', 'company' => 'SMI Liberia', 'type' => 'technical', 'country' => 'Liberia'],
            ['name' => 'Fonds de Développement Agricole', 'company' => 'FDA Sierra Leone', 'type' => 'investor', 'country' => 'Sierra Leone'],
            ['name' => 'Alliance Paysans Durables', 'company' => 'APD Gambie', 'type' => 'institutional', 'country' => 'Gambie'],
            ['name' => 'Innovation Tech Sénégal', 'company' => 'ITS Dakar', 'type' => 'technical', 'country' => 'Sénégal'],
            ['name' => 'Investisseurs Verts Ouest-Africains', 'company' => 'IVOA Fund', 'type' => 'investor', 'country' => 'Sénégal'],
            ['name' => 'Coopérative Nationale des Agriculteurs', 'company' => 'CNA Mali', 'type' => 'institutional', 'country' => 'Mali'],
        ];

        foreach ($partners as $index => $partnerData) {
            $type = $partnerData['type'];
            $country = $partnerData['country'];
            $name = $partnerData['name'];
            $company = $partnerData['company'];

            // Créer l'utilisateur partenaire
            $partnerUser = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $company)) . '@partner.local'],
                [
                    'name' => $name,
                    'password' => Hash::make('partner123'),
                    'role' => 'partner',
                    'country' => $country,
                    'is_active' => true,
                ]
            );

            // Créer le profil partenaire associé
            Partner::firstOrCreate(
                ['user_id' => $partnerUser->id],
                [
                    'company_name' => $company,
                    'type' => $type,
                    'description' => "Partenaire {$type} basé en {$country}.",
                    'website' => 'https://example.com',
                    'contact_email' => $partnerUser->email,
                    'status' => $index < 10 ? 'approved' : 'pending',
                    'is_active' => true,
                ]
            );

            $this->command->info("Partenaire créé : {$partnerUser->email} ({$type})");
        }
    }
}
