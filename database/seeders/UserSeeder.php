<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // User::factory(10)->create();
        // for ($i = 1; $i <= 15; $i++) {
        //     User::factory()->create([
        //         'firstname' => $faker->firstNameMale,
        //         'lastname' => $faker->lastName,
        //         'id_paket' => null,
        //         'email' => $faker->safeEmail,
        //         'password' => Hash::make('12345678'),
        //         'telepon' => $faker->phoneNumber,
        //         'alamat' => $faker->address,
        //         'email_verified_at' => now(),
        //         'role' => 'member',
        //     ]);
        // }

        User::create([
            'firstname' => 'ADMIN',
            'lastname' => 'SHOWME',
            'email' => 'admin@mail.com',
            'password' => Hash::make('Showme354'),
            'telepon' => $faker->phoneNumber,
            'alamat' => $faker->address,
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
        User::create([
            'firstname' => 'OPERATOR',
            'lastname' => 'SHOWME',
            'email' => 'operator@mail.com',
            'password' => Hash::make('Showme354'),
            'telepon' => $faker->phoneNumber,
            'alamat' => $faker->address,
            'email_verified_at' => now(),
            'role' => 'operator',
        ]);
        User::create([
            'firstname' => 'MEMBER',
            'lastname' => 'SHOWME',
            'email' => 'member@mail.com',
            'password' => Hash::make('Showme354'),
            'telepon' => $faker->phoneNumber,
            'alamat' => $faker->address,
            'email_verified_at' => now(),
            'role' => 'member',
        ]);
    }
}
