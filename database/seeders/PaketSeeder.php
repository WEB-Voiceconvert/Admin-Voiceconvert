<?php

namespace Database\Seeders;

use App\Models\Paket;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // User::factory(10)->create();
        for ($i = 1; $i <= 5; $i++) {

            Paket::factory()->create([
                'jenis_paket' => $faker->words($nb = 2, $asText = true),
                'nominal' => $faker->biasedNumberBetween($min = 100000, $max = 200000, $function = 'sqrt'),
                'masa_berlaku' => 30,
            ]);
        }
    }
}
