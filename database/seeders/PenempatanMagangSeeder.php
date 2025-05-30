<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Reference\PengajuanMagangModel;
use App\Models\Auth\MahasiswaModel;

class PenempatanMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan semua pengajuan magang yang sudah diterima
        $pengajuanMagang = PengajuanMagangModel::where('status', 'Diterima')
            ->get();

        if ($pengajuanMagang->isEmpty()) {
            $this->command->info('Tidak ada pengajuan magang yang diterima. Membuat pengajuan dummy terlebih dahulu.');
            
            // Membuat pengajuan magang dummy jika tidak ada
            $this->createDummyPengajuan();
            
            // Mendapatkan pengajuan yang baru dibuat
            $pengajuanMagang = PengajuanMagangModel::where('status', 'Diterima')
                ->get();
        }
        
        // Distribusi jumlah mahasiswa per bulan (untuk 12 bulan terakhir)
        $monthlyDistribution = [
            11 => 3,  // 11 bulan yang lalu
            10 => 5,  // 10 bulan yang lalu
            9 => 6,   // 9 bulan yang lalu
            8 => 4,   // 8 bulan yang lalu
            7 => 7,   // 7 bulan yang lalu
            6 => 8,   // 6 bulan yang lalu
            5 => 10,  // 5 bulan yang lalu
            4 => 12,  // 4 bulan yang lalu
            3 => 15,  // 3 bulan yang lalu
            2 => 10,  // 2 bulan yang lalu
            1 => 8,   // 1 bulan yang lalu
            0 => 5,   // Bulan ini
        ];
        
        $penempatanData = [];
        $pengajuanIndex = 0;
        
        // Buat data berdasarkan distribusi bulanan
        foreach ($monthlyDistribution as $monthsAgo => $count) {
            $date = Carbon::now()->subMonths($monthsAgo);
            
            // Bagi bulan menjadi dua periode (awal bulan dan akhir bulan)
            $firstHalfCount = ceil($count / 2);
            $secondHalfCount = $count - $firstHalfCount;
            
            // Penempatan di awal bulan
            for ($i = 0; $i < $firstHalfCount; $i++) {
                // Pastikan indeks tidak melebihi jumlah pengajuan
                if ($pengajuanIndex >= count($pengajuanMagang)) {
                    $pengajuanIndex = 0; // Reset indeks jika semua pengajuan sudah digunakan
                }
                
                $pengajuan = $pengajuanMagang[$pengajuanIndex++];
                $createdAt = $date->copy()->addDays(rand(1, 10));
                
                $penempatanData[] = [
                    'id_mahasiswa' => $pengajuan->id_mahasiswa,
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'status' => $monthsAgo <= 2 ? 'Berlangsung' : 'Selesai',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }
            
            // Penempatan di akhir bulan
            for ($i = 0; $i < $secondHalfCount; $i++) {
                // Pastikan indeks tidak melebihi jumlah pengajuan
                if ($pengajuanIndex >= count($pengajuanMagang)) {
                    $pengajuanIndex = 0;
                }
                
                $pengajuan = $pengajuanMagang[$pengajuanIndex++];
                $createdAt = $date->copy()->addDays(rand(15, 28));
                
                $penempatanData[] = [
                    'id_mahasiswa' => $pengajuan->id_mahasiswa,
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'status' => $monthsAgo <= 2 ? 'Berlangsung' : 'Selesai',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }
        }
        
        // Masukkan data ke database
        DB::table('t_penempatan_magang')->insert($penempatanData);
        
        $this->command->info('Berhasil menyeeder ' . count($penempatanData) . ' data penempatan magang');
    }
    
    /**
     * Membuat data dummy pengajuan magang jika tidak ada pengajuan yang diterima
     */
    private function createDummyPengajuan(): void
    {
        // Dapatkan semua mahasiswa yang ada
        $mahasiswas = MahasiswaModel::take(30)->get();
        
        if ($mahasiswas->isEmpty()) {
            $this->command->error('Tidak ada data mahasiswa. Mohon jalankan seeder Mahasiswa terlebih dahulu.');
            return;
        }
        
        // Buat pengajuan magang diterima untuk setiap mahasiswa
        $pengajuanData = [];
        
        foreach ($mahasiswas as $index => $mahasiswa) {
            // Bagi mahasiswa untuk berbagai lowongan
            $lowonganId = ($index % 5) + 1; // Asumsikan ada 5 lowongan
            
            $createdAt = Carbon::now()->subMonths(rand(1, 12))->subDays(rand(1, 30));
            $approvedAt = $createdAt->copy()->addDays(rand(3, 10));
            
            $pengajuanData[] = [
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'id_lowongan' => $lowonganId,
                'status' => 'Diterima',
                'tanggal_diterima' => $approvedAt,
                'created_at' => $createdAt,
                'updated_at' => $approvedAt,
            ];
        }
        
        // Masukkan data pengajuan
        DB::table('t_pengajuan_magang')->insert($pengajuanData);
        
        $this->command->info('Berhasil membuat ' . count($pengajuanData) . ' pengajuan magang dummy');
    }
}