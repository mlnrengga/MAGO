<?php

namespace Database\Seeders;

use App\Models\Reference\DaerahMagangModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaerahMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $csvFile = database_path('seeders/dataset/daerah_magang_dataset.csv');
        $csvFile = database_path('seeders/dataset/daerah_magang_dataset_with_coords.csv');
        $csv = fopen($csvFile, 'r');

        // Skip header
        fgetcsv($csv);

        $totalRows = count(file($csvFile)) - 1; // Total rows excluding header

        // while (($data = fgetcsv($csv)) !== FALSE) {
        //     DaerahMagangModel::updateOrCreate(
        //         ['id_daerah_magang' => $data[0]],
        //         [
        //             'nama_daerah' => $data[1],
        //             'jenis_daerah' => $data[2],
        //             'id_provinsi' => $data[3],
        //             'latitude' => $data[4],
        //             'longitude' => $data[5]
        //         ]
        //     );
        // }

        while (($data = fgetcsv($csv)) !== FALSE) {
            // Pastikan ada 6 kolom
            if (count($data) < 6) {
                // print_r($data);
                continue;
            }
            DaerahMagangModel::updateOrCreate(
                ['id_daerah_magang' => $data[0]],
                [
                    'nama_daerah' => $data[1],
                    'jenis_daerah' => $data[2],
                    'id_provinsi' => $data[3],
                    'latitude' => $data[4],
                    'longitude' => $data[5]
                ]
            );
        }

        fclose($csv);

        $this->command->info('Berhasil menyeeder ' . $totalRows . ' data daerah magang');
    }
}
