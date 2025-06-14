<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LowonganMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_lowongan_magang')->delete();
        DB::statement('ALTER TABLE t_lowongan_magang AUTO_INCREMENT = 1');

        $periodeList = DB::table('m_periode')
            ->whereIn('nama_periode', ['2024/2025 Ganjil', '2024/2025 Genap'])
            ->get();

        // Ambil data perusahaan lengkap dengan nama
        $perusahaanList = DB::table('m_perusahaan')->get();
        if ($perusahaanList->isEmpty()) {
            throw new \Exception('Tabel m_perusahaan kosong. Harap isi terlebih dahulu.');
        }

        $waktuMagang = DB::table('m_waktu_magang')->pluck('id_waktu_magang')->toArray();
        $daerah = DB::table('m_daerah_magang')->pluck('id_daerah_magang')->toArray();
        $jenisMagang = DB::table('m_jenis_magang')->pluck('id_jenis_magang')->toArray();
        $insentif = DB::table('m_insentif')->pluck('id_insentif')->toArray();
        
        // Daftar judul dan deskripsi lowongan profesional 
        $lowonganTemplates = [
            [
                'judul' => 'Magang Web Developer',
                'deskripsi' => 'Lowongan magang posisi Web Developer untuk mengembangkan aplikasi web menggunakan Laravel, React, atau Vue.js. Kandidat akan terlibat dalam pengembangan fitur, implementasi UI, dan integrasi API. Persyaratan: Mahasiswa semester 6-8 jurusan Teknik Informatika/Sistem Informasi dengan pemahaman dasar HTML, CSS, JavaScript.'
            ],
            [
                'judul' => 'Magang Mobile Developer',
                'deskripsi' => 'Program magang Mobile Developer untuk mahasiswa yang tertarik mengembangkan aplikasi Android/iOS. Akan terlibat dalam pengembangan aplikasi mobile dari konsep hingga implementasi. Persyaratan: Pemahaman dasar Java/Kotlin/Swift, pemrograman berorientasi objek, dan pengalaman menggunakan Android Studio/Xcode.'
            ],
            [
                'judul' => 'Magang UI/UX Designer',
                'deskripsi' => 'Kesempatan magang sebagai UI/UX Designer untuk merancang antarmuka aplikasi yang menarik dan mudah digunakan. Mahasiswa akan terlibat dalam research, wireframing, prototyping, dan user testing. Diutamakan memiliki portofolio desain dan familiar dengan tools seperti Figma, Adobe XD, atau Sketch.'
            ],
            [
                'judul' => 'Magang Data Analyst',
                'deskripsi' => 'Lowongan magang Data Analyst untuk membantu mengolah dan menganalisis data bisnis. Kandidat akan belajar menggunakan SQL, Python, dan tools visualisasi data untuk menghasilkan insight yang bernilai bagi perusahaan. Diutamakan mahasiswa jurusan Statistik, Matematika, atau Ilmu Komputer.'
            ],
            [
                'judul' => 'Magang Network Engineer',
                'deskripsi' => 'Program magang Network Engineer untuk membantu dalam manajemen infrastruktur jaringan perusahaan. Kandidat akan belajar tentang konfigurasi router, switch, firewall, serta menangani troubleshooting jaringan. Diutamakan mahasiswa dengan pemahaman dasar tentang TCP/IP dan OSI Layer.'
            ],
            [
                'judul' => 'Magang Cyber Security',
                'deskripsi' => 'Kesempatan magang di bidang Cyber Security untuk membantu mengidentifikasi kerentanan sistem dan melindungi infrastruktur IT. Kandidat akan terlibat dalam security assessment, monitoring, dan implementasi best practices keamanan. Diutamakan mahasiswa dengan minat kuat di bidang keamanan informasi.'
            ],
            [
                'judul' => 'Magang DevOps Engineer',
                'deskripsi' => 'Lowongan magang DevOps Engineer untuk membantu mengotomatisasi deployment dan operasional infrastruktur. Mahasiswa akan belajar tentang CI/CD, container, dan cloud services. Persyaratan: Familiar dengan Linux, pemrograman script, dan konsep dasar cloud computing.'
            ],
            [
                'judul' => 'Magang QA Engineer',
                'deskripsi' => 'Program magang Quality Assurance Engineer untuk membantu memastikan kualitas perangkat lunak. Kandidat akan belajar melakukan manual testing, automated testing, dan pelaporan bug. Diutamakan mahasiswa dengan pemahaman dasar tentang SDLC dan testing methodology.'
            ],
            [
                'judul' => 'Magang Frontend Developer',
                'deskripsi' => 'Kesempatan magang sebagai Frontend Developer untuk mengembangkan antarmuka web yang responsif dan interaktif. Kandidat akan bekerja dengan HTML, CSS, JavaScript, dan framework modern seperti React. Diutamakan memiliki portofolio proyek web dan pemahaman tentang UI/UX.'
            ],
            [
                'judul' => 'Magang Backend Developer',
                'deskripsi' => 'Lowongan magang Backend Developer untuk mengembangkan dan memelihara server, database, dan aplikasi. Kandidat akan bekerja dengan bahasa pemrograman seperti PHP, Python, atau Node.js. Persyaratan: Pemahaman dasar tentang REST API, database, dan arsitektur aplikasi.'
            ],
            [
                'judul' => 'Magang Full Stack Developer',
                'deskripsi' => 'Program magang Full Stack Developer untuk mahasiswa yang ingin mengembangkan keahlian di frontend dan backend. Kandidat akan terlibat dalam pengembangan fitur end-to-end, dari database hingga UI. Diutamakan memiliki pengetahuan dasar HTML, CSS, JavaScript, dan minimal satu bahasa backend.'
            ],
            [
                'judul' => 'Magang Business Intelligence',
                'deskripsi' => 'Kesempatan magang di bidang Business Intelligence untuk membantu menganalisis data bisnis dan membuat dashboard interaktif. Kandidat akan belajar menggunakan tools seperti Power BI, Tableau, atau Looker. Diutamakan mahasiswa dengan pemahaman dasar tentang database dan visualisasi data.'
            ],
            [
                'judul' => 'Magang Database Administrator',
                'deskripsi' => 'Lowongan magang Database Administrator untuk membantu mengelola dan mengoptimalkan database perusahaan. Kandidat akan belajar tentang query optimization, backup & recovery, serta monitoring performa. Persyaratan: Pemahaman dasar SQL dan jenis-jenis database.'
            ],
            [
                'judul' => 'Magang Machine Learning',
                'deskripsi' => 'Program magang Machine Learning untuk membantu mengembangkan model prediktif dan algoritma cerdas. Kandidat akan bekerja dengan Python, libraries ML, dan dataset nyata. Diutamakan mahasiswa dengan latar belakang matematika/statistik dan pemahaman dasar tentang algoritma ML.'
            ],
            [
                'judul' => 'Magang IT Support',
                'deskripsi' => 'Kesempatan magang sebagai IT Support untuk membantu menyelesaikan masalah teknis pengguna. Kandidat akan belajar tentang troubleshooting hardware/software, manajemen aset IT, dan helpdesk. Persyaratan: Pemahaman dasar tentang sistem operasi dan jaringan komputer.'
            ],
            [
                'judul' => 'Magang AR/VR Developer',
                'deskripsi' => 'Lowongan magang AR/VR Developer untuk membantu mengembangkan pengalaman augmented dan virtual reality. Kandidat akan bekerja dengan Unity, ARKit/ARCore, atau platform serupa. Diutamakan mahasiswa dengan pemahaman dasar tentang 3D modeling dan game development.'
            ],
            [
                'judul' => 'Magang Cloud Engineer',
                'deskripsi' => 'Program magang Cloud Engineer untuk membantu mengelola dan mengoptimalkan infrastruktur cloud perusahaan. Kandidat akan belajar tentang AWS, Azure, atau GCP, serta praktik Infrastructure as Code. Persyaratan: Pemahaman dasar tentang layanan cloud dan networking.'
            ],
            [
                'judul' => 'Magang Game Developer',
                'deskripsi' => 'Kesempatan magang sebagai Game Developer untuk membantu mengembangkan game menggunakan Unity atau Unreal Engine. Kandidat akan terlibat dalam pembuatan game mechanics, optimasi performa, dan testing. Diutamakan memiliki pengetahuan dasar tentang pemrograman dan game design.'
            ],
            [
                'judul' => 'Magang Blockchain Developer',
                'deskripsi' => 'Lowongan magang Blockchain Developer untuk membantu mengembangkan aplikasi berbasis blockchain. Kandidat akan belajar tentang smart contracts, Ethereum/Hyperledger, dan konsep Web3. Persyaratan: Pemahaman dasar tentang kriptografi dan pemrograman.'
            ],
            [
                'judul' => 'Magang IoT Engineer',
                'deskripsi' => 'Program magang IoT Engineer untuk membantu mengembangkan solusi Internet of Things. Kandidat akan bekerja dengan mikrokontroler, sensor, dan platform IoT. Diutamakan mahasiswa dengan pemahaman dasar elektronika dan pemrograman embedded.'
            ]
        ];

        $data = [];
        $counter = 1;

        foreach ($periodeList as $p) {
            $tahun = intval(substr($p->nama_periode, 0, 4));
            $jenis = strpos($p->nama_periode, 'Ganjil') !== false ? 'Ganjil' : 'Genap';

            if ($jenis == 'Ganjil') {
                $start = Carbon::create($tahun, 7, 1);
            } else {
                $start = Carbon::create($tahun + 1, 1, 1);
            }

            for ($i = 0; $i < 10; $i++) { // 10 lowongan per periode
                // Pilih template lowongan secara acak
                $template = $lowonganTemplates[array_rand($lowonganTemplates)];
                
                // Pilih perusahaan secara acak
                $perusahaan = $perusahaanList->random();
                
                $id_waktu_magang = $waktuMagang[array_rand($waktuMagang)];
                $tanggal_posting = $start->copy()->subMonths(rand(2, 4))->addDays(rand(0, 20));
                $batas_akhir = $start->copy()->subDays(rand(10, 35));
                
                // Buat judul dengan format "Magang [Posisi] di [Nama Perusahaan]"
                $judul = $template['judul'] . ' di ' . $perusahaan->nama;

                $data[] = [
                    'id_lowongan' => $counter++,
                    'id_jenis_magang' => $jenisMagang[array_rand($jenisMagang)],
                    'id_perusahaan' => $perusahaan->id_perusahaan,
                    'id_daerah_magang' => $daerah[array_rand($daerah)],
                    'judul_lowongan' => $judul,
                    'deskripsi_lowongan' => $template['deskripsi'],
                    'tanggal_posting' => $tanggal_posting->format('Y-m-d'),
                    'batas_akhir_lamaran' => $batas_akhir->format('Y-m-d'),
                    'status' => 'Aktif',
                    'id_periode' => $p->id_periode,
                    'id_waktu_magang' => $id_waktu_magang,
                    'id_insentif' => $insentif[array_rand($insentif)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('t_lowongan_magang')->insert($data);
        $this->command->info('Berhasil menyeeder ' . count($data) . ' data lowongan magang');
    }
}