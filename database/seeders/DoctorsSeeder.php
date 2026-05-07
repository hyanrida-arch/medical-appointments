<?php

namespace Database\Seeders;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorsSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'first_name' => 'Karim',
                'last_name' => 'Benjelloun',
                'email' => 'karim.benjelloun@medic.ma',
                'phone' => '+212661234567',
                'specialization' => 'Cardiologie',
                'consultation_fee' => 400,
                'biography' => 'Cardiologue avec 20 ans d\'expérience, spécialisé en cardiologie interventionnelle. Diplômé de la Faculté de Médecine de Rabat.',
            ],
            [
                'first_name' => 'Salma',
                'last_name' => 'El Idrissi',
                'email' => 'salma.elidrissi@medic.ma',
                'phone' => '+212662345678',
                'specialization' => 'Pédiatrie',
                'consultation_fee' => 250,
                'biography' => 'Pédiatre passionnée par la santé infantile. Suit les enfants de 0 à 16 ans. Approche douce et bienveillante.',
            ],
            [
                'first_name' => 'Mohammed',
                'last_name' => 'Tazi',
                'email' => 'mohammed.tazi@medic.ma',
                'phone' => '+212663456789',
                'specialization' => 'Dermatologie',
                'consultation_fee' => 300,
                'biography' => 'Dermatologue spécialisé dans les soins de la peau et le traitement de l\'acné, eczéma, et psoriasis.',
            ],
            [
                'first_name' => 'Nadia',
                'last_name' => 'Berrada',
                'email' => 'nadia.berrada@medic.ma',
                'phone' => '+212664567890',
                'specialization' => 'Gynécologie',
                'consultation_fee' => 350,
                'biography' => 'Gynécologue obstétricienne, suivi de grossesse et soins gynécologiques complets dans un environnement chaleureux.',
            ],
            [
                'first_name' => 'Youssef',
                'last_name' => 'Alaoui',
                'email' => 'youssef.alaoui@medic.ma',
                'phone' => '+212665678901',
                'specialization' => 'Orthopédie',
                'consultation_fee' => 380,
                'biography' => 'Chirurgien orthopédiste, spécialisé dans les traumatismes sportifs et la chirurgie du genou.',
            ],
            [
                'first_name' => 'Laila',
                'last_name' => 'Chraibi',
                'email' => 'laila.chraibi@medic.ma',
                'phone' => '+212666789012',
                'specialization' => 'Ophtalmologie',
                'consultation_fee' => 280,
                'biography' => 'Ophtalmologue, examens de la vue, traitement des maladies oculaires et chirurgie réfractive.',
            ],
            [
                'first_name' => 'Omar',
                'last_name' => 'Benkirane',
                'email' => 'omar.benkirane@medic.ma',
                'phone' => '+212667890123',
                'specialization' => 'Médecine générale',
                'consultation_fee' => 200,
                'biography' => 'Médecin généraliste, médecine de famille, suivi médical au long cours pour adultes et enfants.',
            ],
            [
                'first_name' => 'Amina',
                'last_name' => 'Saidi',
                'email' => 'amina.saidi@medic.ma',
                'phone' => '+212668901234',
                'specialization' => 'Psychiatrie',
                'consultation_fee' => 500,
                'biography' => 'Psychiatre, prise en charge de l\'anxiété, dépression, troubles du sommeil. Approche thérapeutique intégrative.',
            ],
        ];

        foreach ($doctors as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'password' => Hash::make('password123'),
                    'role' => 'doctor',
                    'email_verified_at' => now(),
                ]
            );

            DoctorProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization' => $data['specialization'],
                    'consultation_fee' => $data['consultation_fee'],
                    'biography' => $data['biography'],
                ]
            );
        }

        $this->command->info('✓ 8 fake doctors created/updated.');
    }
}