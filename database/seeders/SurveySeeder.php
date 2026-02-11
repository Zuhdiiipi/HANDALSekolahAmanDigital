<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveyCategory;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use Illuminate\Support\Facades\DB;

class SurveySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SurveyCategory::truncate();
        SurveyQuestion::truncate();
        SurveyQuestionOption::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data Survey 
        $data = [
            // ==========================================
            // KATEGORI 1: SDM & LITERASI DIGITAL
            // ==========================================
            [
                'name' => 'SDM & Literasi Digital',
                'questions' => [
                    [
                        'text' => 'Kesadaran Cyber bullying',
                        'options' => [
                            ['score' => 1, 'text' => '<20%'],
                            ['score' => 2, 'text' => '40%'],
                            ['score' => 3, 'text' => '60%'],
                            ['score' => 4, 'text' => '70%'],
                            ['score' => 5, 'text' => '90%>'],
                        ]
                    ],
                    [
                        'text' => '% kelulusan peserta microskill',
                        'options' => [
                            ['score' => 1, 'text' => '<20%'],
                            ['score' => 2, 'text' => '20-49%'],
                            ['score' => 3, 'text' => '50-69%'],
                            ['score' => 4, 'text' => '70-89%'],
                            ['score' => 5, 'text' => '90%>'],
                        ]
                    ],
                    [
                        'text' => 'Partisipasi lomba digital / Bidang Teknologi',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Pernah'],
                            ['score' => 2, 'text' => '1 Lokal'],
                            ['score' => 3, 'text' => '2 Lokal'],
                            ['score' => 4, 'text' => '1 Provinsi'],
                            ['score' => 5, 'text' => '>= 1 Nasional'],
                        ]
                    ],
                    [
                        'text' => 'SDM background IT',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Ada'],
                            ['score' => 2, 'text' => '1 Orang'],
                            ['score' => 3, 'text' => '2 Orang'],
                            ['score' => 4, 'text' => '3 Orang'],
                            ['score' => 5, 'text' => '4 Orang Atau Lebih'],
                        ]
                    ],
                    [
                        'text' => 'Komunitas / Grup Belajar / ekstrakurikuler Siswa bidang teknologi',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Ada'],
                            ['score' => 2, 'text' => '1 Tema'],
                            ['score' => 3, 'text' => '2 Tema'],
                            ['score' => 4, 'text' => '3 Tema'],
                            ['score' => 5, 'text' => '4 Atau Lebih Tema'],
                        ]
                    ],
                    [
                        'text' => 'Pelatihan pengembangan SDM Internal dibidang TIK.',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Pernah'],
                            ['score' => 2, 'text' => 'Jarang (1x setahun)'],
                            ['score' => 3, 'text' => 'Cukup (1x per semester)'],
                            ['score' => 4, 'text' => 'Rutin (Triwulan)'],
                            ['score' => 5, 'text' => 'Sangat Rutin & Terjadwal'],
                        ]
                    ],
                    [
                        'text' => 'Tim teknis/dukungan IT',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Ada'],
                            ['score' => 2, 'text' => 'Merangkap Guru'],
                            ['score' => 3, 'text' => 'Ada (Paruh Waktu)'],
                            ['score' => 4, 'text' => 'Ada (Penuh Waktu)'],
                            ['score' => 5, 'text' => 'Tim IT Profesional Lengkap'],
                        ]
                    ],
                ]
            ],

            // ==========================================
            // KATEGORI 2: INFRASTRUKTUR DIGITAL
            // ==========================================
            [
                'name' => 'Infrastruktur Digital',
                'questions' => [
                    [
                        'text' => 'Spesifikasi Perangkat Komputer (Benchmarking)',
                        'options' => [
                            ['score' => 1, 'text' => 'Sangat Rendah'],
                            ['score' => 2, 'text' => 'Rendah'],
                            ['score' => 3, 'text' => 'Cukup'],
                            ['score' => 4, 'text' => 'Tinggi'],
                            ['score' => 5, 'text' => 'Sangat Tinggi (High-End)'],
                        ]
                    ],
                    [
                        'text' => 'Perangkat Lainnya (LCD Proyektor, Wifi, dll)',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Memadai'],
                            ['score' => 2, 'text' => 'Kurang Memadai'],
                            ['score' => 3, 'text' => 'Cukup Memadai'],
                            ['score' => 4, 'text' => 'Memadai'],
                            ['score' => 5, 'text' => 'Sangat Lengkap & Canggih'],
                        ]
                    ],
                    [
                        'text' => 'Rasio perangkat komputer per siswa',
                        'options' => [
                            ['score' => 1, 'text' => '1 : >5 Siswa'],
                            ['score' => 2, 'text' => '1 : 4 Siswa'],
                            ['score' => 3, 'text' => '1 : 3 Siswa'],
                            ['score' => 4, 'text' => '1 : 2 Siswa'],
                            ['score' => 5, 'text' => '1 : 1 Siswa (Ideal)'],
                        ]
                    ],
                    [
                        'text' => 'Ketersediaan internet stabil',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Ada Internet'],
                            ['score' => 2, 'text' => 'Sering Gangguan'],
                            ['score' => 3, 'text' => 'Cukup Stabil'],
                            ['score' => 4, 'text' => 'Stabil & Cepat'],
                            ['score' => 5, 'text' => 'Sangat Cepat (Dedicated)'],
                        ]
                    ],
                    [
                        'text' => 'Penggunaan LMS/e-learning',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Menggunakan'],
                            ['score' => 2, 'text' => 'Hanya Share Materi (WA/Drive)'],
                            ['score' => 3, 'text' => 'Menggunakan Google Classroom'],
                            ['score' => 4, 'text' => 'LMS Terintegrasi Sederhana'],
                            ['score' => 5, 'text' => 'LMS Full Fitur (Moodle/Custom)'],
                        ]
                    ],
                ]
            ],

            // ==========================================
            // KATEGORI 3: KEAMANAN DIGITAL
            // ==========================================
            [
                'name' => 'Keamanan Digital',
                'questions' => [
                    [
                        'text' => 'Kebijakan pembatasan penggunaan perangkat elektronik',
                        'options' => [
                            ['score' => 1, 'text' => 'Bebas Tanpa Aturan'],
                            ['score' => 2, 'text' => 'Ada Aturan Lisan'],
                            ['score' => 3, 'text' => 'Aturan Tertulis (Jarang Diterapkan)'],
                            ['score' => 4, 'text' => 'Aturan Tertulis & Diterapkan'],
                            ['score' => 5, 'text' => 'Kebijakan Ketat & Dipantau Sistem'],
                        ]
                    ],
                    [
                        'text' => 'Analisa Riwayat Komputer',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Pernah Dicek'],
                            ['score' => 2, 'text' => 'Jarang Dicek'],
                            ['score' => 3, 'text' => 'Dicek Manual Berkala'],
                            ['score' => 4, 'text' => 'Dicek Rutin Mingguan'],
                            ['score' => 5, 'text' => 'Monitoring Realtime/Log Server'],
                        ]
                    ],
                    [
                        'text' => 'Penerapan Keamanan Lainnya',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Ada Pengamanan'],
                            ['score' => 2, 'text' => 'Hanya Antivirus Gratis'],
                            ['score' => 3, 'text' => 'Antivirus Berbayar'],
                            ['score' => 4, 'text' => 'Antivirus & Firewall'],
                            ['score' => 5, 'text' => 'Keamanan Berlapis (AV, Firewall, Proxy)'],
                        ]
                    ],
                    [
                        'text' => 'Backup data & Penanganan Insiden',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Ada Backup'],
                            ['score' => 2, 'text' => 'Backup Manual Jarang'],
                            ['score' => 3, 'text' => 'Backup Manual Rutin'],
                            ['score' => 4, 'text' => 'Backup Otomatis Lokal'],
                            ['score' => 5, 'text' => 'Backup Otomatis Cloud & SOP Insiden'],
                        ]
                    ],
                ]
            ],

            // ==========================================
            // KATEGORI 4: SOSIAL DIGITAL
            // ==========================================
            [
                'name' => 'Sosial Digital',
                'questions' => [
                    [
                        'text' => 'Kesadaran Jejak Digital',
                        'options' => [
                            ['score' => 1, 'text' => 'Sangat Rendah'],
                            ['score' => 2, 'text' => 'Rendah'],
                            ['score' => 3, 'text' => 'Cukup'],
                            ['score' => 4, 'text' => 'Tinggi'],
                            ['score' => 5, 'text' => 'Sangat Tinggi'],
                        ]
                    ],
                    [
                        'text' => 'Positif Sosial Media',
                        'options' => [
                            ['score' => 1, 'text' => 'Sering Ada Konflik/Negatif'],
                            ['score' => 2, 'text' => 'Kurang Kondusif'],
                            ['score' => 3, 'text' => 'Netral'],
                            ['score' => 4, 'text' => 'Positif'],
                            ['score' => 5, 'text' => 'Sangat Positif & Produktif'],
                        ]
                    ],
                    [
                        'text' => 'Interaksi Digital yang Inklusif dan Toleran',
                        'options' => [
                            ['score' => 1, 'text' => 'Sangat Buruk'],
                            ['score' => 2, 'text' => 'Buruk'],
                            ['score' => 3, 'text' => 'Cukup'],
                            ['score' => 4, 'text' => 'Baik'],
                            ['score' => 5, 'text' => 'Sangat Baik'],
                        ]
                    ],
                    [
                        'text' => 'Pemahaman terkait berita "HOAX"',
                        'options' => [
                            ['score' => 1, 'text' => 'Mudah Percaya Hoax'],
                            ['score' => 2, 'text' => 'Kurang Paham Cek Fakta'],
                            ['score' => 3, 'text' => 'Cukup Paham'],
                            ['score' => 4, 'text' => 'Kritis Terhadap Informasi'],
                            ['score' => 5, 'text' => 'Sangat Kritis & Aktif Mengklarifikasi'],
                        ]
                    ],
                    [
                        'text' => 'Pemahaman terkait Privasi digital dan Doxing',
                        'options' => [
                            ['score' => 1, 'text' => 'Tidak Peduli Privasi'],
                            ['score' => 2, 'text' => 'Kurang Hati-hati'],
                            ['score' => 3, 'text' => 'Cukup Hati-hati'],
                            ['score' => 4, 'text' => 'Menjaga Privasi'],
                            ['score' => 5, 'text' => 'Sangat Menjaga & Mengedukasi Lainnya'],
                        ]
                    ],
                ]
            ],
        ];

        // 3. Eksekusi Loop untuk Menyimpan ke Database
        foreach ($data as $cat) {
            $category = SurveyCategory::create(['name' => $cat['name']]);

            foreach ($cat['questions'] as $q) {
                $question = $category->questions()->create([
                    'question_text' => $q['text'],
                    'type' => 'mcq'
                ]);

                foreach ($q['options'] as $opt) {
                    $question->options()->create([
                        'option_text' => $opt['text'],
                        'score_value' => $opt['score']
                    ]);
                }
            }
        }
    }
}
