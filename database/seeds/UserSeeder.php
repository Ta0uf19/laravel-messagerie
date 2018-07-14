<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create(); // générer des pseudo aléatoire

        for ($i = 0; $i < 10; $i++) {
            \Illuminate\Support\Facades\DB::table('users')->insert([
                'name'     => $faker->firstName,
                'email'    => $faker->email,
                'password' => bcrypt('0000'), //mot de passe par défaut
            ]);
        }
    }
}
