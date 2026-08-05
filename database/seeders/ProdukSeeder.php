<?php

namespace Database\Seeders;

use App\Models\Jenis;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID user dan jenis yang ada
        $userIds = User::pluck('id')->toArray();
        $jenisIds = Jenis::pluck('id')->toArray();

        // Buat 100 produk dengan acakan user_id dan jenis_id
        Produk::factory()->count(100)->create([
            'user_id' => fake()->randomElement($userIds),
            'jenis_id' => fake()->randomElement($jenisIds),
        ]);
    }
}