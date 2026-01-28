<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionOption extends Model
{
    protected $fillable = ['question_id', 'option_text', 'score_value'];

    public function question()
    {
        // TAMBAHKAN 'question_id'
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }
}
