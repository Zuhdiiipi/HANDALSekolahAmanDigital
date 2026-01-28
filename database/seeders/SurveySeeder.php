<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveyCategory;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;

class SurveySeeder extends Seeder
{
    public function run()
    {
        // 1. Kategori: Infrastruktur (Bobot 40%)
        $cat1 = SurveyCategory::create(['name' => 'Infrastruktur Teknologi', 'weight' => 40]);

        // Soal 1.1 (Bobot 100% dari kategori ini)
        $q1 = SurveyQuestion::create([
            'category_id' => $cat1->id,
            'question_text' => 'Apakah sekolah memiliki Firewall aktif?',
            'type' => 'mcq',
            'weight' => 100
        ]);
        // Opsi Soal 1.1
        SurveyQuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Ya, Hardware Dedicated', 'score_value' => 100]);
        SurveyQuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Ya, Software Only', 'score_value' => 50]);
        SurveyQuestionOption::create(['question_id' => $q1->id, 'option_text' => 'Tidak Ada', 'score_value' => 0]);


        // 2. Kategori: SDM (Bobot 30%)
        $cat2 = SurveyCategory::create(['name' => 'Sumber Daya Manusia', 'weight' => 30]);

        // Soal 2.1
        $q2 = SurveyQuestion::create([
            'category_id' => $cat2->id,
            'question_text' => 'Apakah ada guru khusus TIK?',
            'type' => 'mcq',
            'weight' => 100
        ]);
        SurveyQuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Ada, Bersertifikat', 'score_value' => 100]);
        SurveyQuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Ada, Belum Sertifikat', 'score_value' => 50]);
        SurveyQuestionOption::create(['question_id' => $q2->id, 'option_text' => 'Tidak Ada', 'score_value' => 0]);

        // 3. Kategori: Kebijakan (Bobot 30%)
        $cat3 = SurveyCategory::create(['name' => 'Kebijakan Keamanan', 'weight' => 30]);

        // Soal 3.1
        $q3 = SurveyQuestion::create([
            'category_id' => $cat3->id,
            'question_text' => 'Apakah ada SOP penggunaan laboratorium?',
            'type' => 'mcq',
            'weight' => 100
        ]);
        SurveyQuestionOption::create(['question_id' => $q3->id, 'option_text' => 'Ada dan Dijalankan', 'score_value' => 100]);
        SurveyQuestionOption::create(['question_id' => $q3->id, 'option_text' => 'Ada tapi Formalitas', 'score_value' => 50]);
        SurveyQuestionOption::create(['question_id' => $q3->id, 'option_text' => 'Tidak Ada', 'score_value' => 0]);
    }
}
