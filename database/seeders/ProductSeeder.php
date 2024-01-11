<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {

            Product::factory()->create([
                'judul' => $faker->words($nb = 2, $asText = true),
                'deskripsi' => $faker->paragraphs($nb = 4, $asText = true),
                'harga' => '1000000',
            ]);
        }
    }
}
