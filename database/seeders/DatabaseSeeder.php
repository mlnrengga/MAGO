<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Calling all the seeder ~khip

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProdiSeeder::class,
            BidangKeahlianSeeder::class,
            JenisMagangSeeder::class,
            ProvinsiSeeder::class,
            DaerahMagangSeeder::class,
            DosenPembimbingSeeder::class,
            AdminSeeder::class,
            MahasiswaSeeder::class,
            PerusahaanSeeder::class,
            PeriodeSeeder::class,
            WaktuMagangSeeder::class,
            InsentifSeeder::class,
            LowonganMagangSeeder::class,
            PengajuanMagangSeeder::class,
            PreferensiMahasiswaSeeder::class,
            PreferensiJenisMagangSeeder::class,
            PreferensiBidangSeeder::class,
            DospemBidangKeahlianSeeder::class,
            LowonganBidangSeeder::class,
            PenempatanMagangSeeder::class,
        ]);

    }
}
