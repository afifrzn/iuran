<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Participant;

class ParticipantSeeder extends Seeder
{
    public function run()
    {
        $tanpaMakan = [
            'Vito','Owi','Fara','Ryan','Ragil','Debby','Ezar',
            'Tio','Devan','Iqbal','Balgis','Akram','Aiman',
            'Valen','Nabil','Kenji'
        ];

        $denganMakan = [
            'Rafa','Mela','Desthrie','Rendy','Axel','Azizah','Tarisa',
            'Ayu','Nio','Salwa','Elma','Radit','Ryu','Fawaz',
            'Abi A','Adib','Elang','Bagus','Ramzi','Naila',
            'Arga','Attaya','Afif','Farel','Abi P','Widi'
        ];

        // TANPA MAKAN (100K)
        foreach ($tanpaMakan as $nama) {
            Participant::create([
                'name' => trim($nama),
                'with_meal' => false,
                'amount' => 100000,
                'paid' => false
            ]);
        }

        // DENGAN MAKAN (138K)
        foreach ($denganMakan as $nama) {
            Participant::create([
                'name' => trim($nama),
                'with_meal' => true,
                'amount' => 138000,
                'paid' => false
            ]);
        }
    }
}