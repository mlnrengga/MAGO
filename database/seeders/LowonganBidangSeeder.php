<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LowonganBidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r_lowongan_bidang')->delete();
        
        // Ambil semua lowongan magang
        $lowongan = DB::table('t_lowongan_magang')->get();
        
        // Ambil semua bidang keahlian
        $bidangKeahlian = DB::table('m_bidang_keahlian')->pluck('id_bidang', 'nama_bidang_keahlian')->toArray();
        
        // Mapping yang tepat antara judul lowongan dan bidang keahlian utama dan sekunder
        $lowonganToBidang = [
            'Web Developer' => [
                'utama' => ['Web Development'],
                'sekunder' => ['DevOps', 'UI/UX Design', 'Software Testing']
            ],
            'Mobile Developer' => [
                'utama' => ['Mobile Development'],
                'sekunder' => ['UI/UX Design', 'Software Testing']
            ],
            'UI/UX Designer' => [
                'utama' => ['UI/UX Design'],
                'sekunder' => ['Web Development', 'Mobile Development']
            ],
            'Data Analyst' => [
                'utama' => ['Data Analysis'],
                'sekunder' => ['Business Intelligence', 'Machine Learning']
            ],
            'Network Engineer' => [
                'utama' => ['Network Engineering'],
                'sekunder' => ['Cloud Computing', 'IT Support', 'Cyber Security']
            ],
            'Security Analyst' => [
                'utama' => ['Cyber Security'],
                'sekunder' => ['Network Engineering', 'Digital Forensics']
            ],
            'Cyber Security' => [
                'utama' => ['Cyber Security'],
                'sekunder' => ['Network Engineering', 'Digital Forensics']
            ],
            'DevOps Engineer' => [
                'utama' => ['DevOps'],
                'sekunder' => ['Cloud Computing', 'Network Engineering', 'Database Administration']
            ],
            'QA Engineer' => [
                'utama' => ['Software Testing'],
                'sekunder' => ['Web Development', 'Mobile Development', 'DevOps']
            ],
            'Frontend Developer' => [
                'utama' => ['Web Development'],
                'sekunder' => ['UI/UX Design']
            ],
            'Backend Developer' => [
                'utama' => ['Web Development'],
                'sekunder' => ['Database Administration', 'DevOps']
            ],
            'Full Stack Developer' => [
                'utama' => ['Web Development'],
                'sekunder' => ['Database Administration', 'UI/UX Design', 'DevOps']
            ],
            'Business Intelligence' => [
                'utama' => ['Business Intelligence'],
                'sekunder' => ['Data Analysis', 'Database Administration']
            ],
            'Database Administrator' => [
                'utama' => ['Database Administration'],
                'sekunder' => ['DevOps', 'Data Analysis']
            ],
            'Machine Learning' => [
                'utama' => ['Machine Learning'],
                'sekunder' => ['Artificial Intelligence', 'Data Analysis']
            ],
            'IT Support' => [
                'utama' => ['IT Support'],
                'sekunder' => ['Network Engineering']
            ],
            'AR/VR Developer' => [
                'utama' => ['AR/VR Development'],
                'sekunder' => ['Game Development', 'Mobile Development']
            ],
            'Cloud Engineer' => [
                'utama' => ['Cloud Computing'],
                'sekunder' => ['DevOps', 'Network Engineering']
            ],
            'Game Developer' => [
                'utama' => ['Game Development'],
                'sekunder' => ['AR/VR Development', 'Mobile Development']
            ],
            'Blockchain Developer' => [
                'utama' => ['Blockchain Development'],
                'sekunder' => ['Web Development', 'Cyber Security']
            ],
            'IoT Engineer' => [
                'utama' => ['Embedded Systems'],
                'sekunder' => ['Robotic Process Automation', 'Network Engineering']
            ]
        ];
        
        $lowonganBidang = [];
        $timestamp = now();
        
        foreach ($lowongan as $job) {
            // Extract job title from full title (removing "di [perusahaan]")
            $titleParts = explode(' di ', $job->judul_lowongan);
            $jobTitle = $titleParts[0];
            
            // Find matching key in mapping
            $matchedKey = null;
            foreach (array_keys($lowonganToBidang) as $key) {
                if (Str::contains($jobTitle, $key)) {
                    $matchedKey = $key;
                    break;
                }
            }
            
            // Selected bidang IDs to be added
            $selectedBidangIds = [];
            
            if ($matchedKey) {
                // Add primary bidang keahlian (1-2)
                foreach ($lowonganToBidang[$matchedKey]['utama'] as $namaBidang) {
                    if (isset($bidangKeahlian[$namaBidang])) {
                        $selectedBidangIds[] = $bidangKeahlian[$namaBidang];
                    }
                }
                
                // Add 1-2 secondary bidang keahlian
                $sekunder = $lowonganToBidang[$matchedKey]['sekunder'];
                shuffle($sekunder);
                $secondaryCount = min(count($sekunder), rand(1, 2));
                
                for ($i = 0; $i < $secondaryCount; $i++) {
                    if (isset($bidangKeahlian[$sekunder[$i]])) {
                        $selectedBidangIds[] = $bidangKeahlian[$sekunder[$i]];
                    }
                }
            } else {
                // Fallback: get 2-3 random bidang
                $randBidang = array_rand($bidangKeahlian, min(3, count($bidangKeahlian)));
                if (!is_array($randBidang)) {
                    $randBidang = [$randBidang];
                }
                
                foreach ($randBidang as $namaBidang) {
                    $selectedBidangIds[] = $bidangKeahlian[$namaBidang];
                }
            }
            
            // Create records
            foreach (array_unique($selectedBidangIds) as $bidangId) {
                $lowonganBidang[] = [
                    'id_lowongan' => $job->id_lowongan,
                    'id_bidang' => $bidangId,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
            }
        }
        
        if (!empty($lowonganBidang)) {
            DB::table('r_lowongan_bidang')->insert($lowonganBidang);
            $this->command->info('Berhasil menyeeder ' . count($lowonganBidang) . ' data relasi lowongan bidang');
        } else {
            $this->command->error('Tidak ada data relasi lowongan bidang yang dibuat!');
        }
    }
}