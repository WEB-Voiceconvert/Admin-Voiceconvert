<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // User::factory(10)->create();
        for ($i = 1; $i <= 5; $i++) {
            EventCategory::factory()->create([
                'nama_kategori' => $faker->words($nb = 2, $asText = true),
            ]);
        }
    }
}
