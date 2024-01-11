<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Berita;
use App\Models\Event;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // User::factory(10)->create();
        for ($i = 1; $i <= 5; $i++) {
            $uuid = (string) Str::uuid();
            Alat::factory()->create([
                'id' => $uuid,
                'lokasi' => $faker->streetName(),
                'latitude' => $faker->latitude($min = -90, $max = 90),
                'longitude' => $faker->longitude($min = -180, $max = 180),
                'tegangan' => rand(10, 150) / 10,
            ]);
            for ($j = 0; $j <= 3; $j++) {
                Berita::factory()->create([
                    'judul' => $faker->words($nb = 5, $asText = true),
                    'id_alat' => $uuid,
                    'gambar' => $faker->imageUrl($width = 640, $height = 480),
                    'deskripsi' => $faker->paragraphs($nb = 9, $asText = true),
                ]);
                Event::factory()->create([
                    'id_alat' => $uuid,
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
}
