<?php

namespace Database\Seeders;

use App\Models\Event;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 25; $i++) {

            Event::factory()->create([
                'id_category' => $faker->randomElement([1, 2, 3, 4, 5]),
                'nama_event' => $faker->words($nb = 3, $asText = true),
                'lokasi' => $faker->country,
                'latitude' => $faker->latitude($min = -90, $max = 90),
                'longitude' => $faker->longitude($min = -180, $max = 180),
                'deskripsi' => $faker->text($maxNbChars = 200),
                'tgl_event' => $faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            ]);
        }
    }
}
