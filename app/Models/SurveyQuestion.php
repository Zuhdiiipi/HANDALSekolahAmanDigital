<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $fillable = ['category_id', 'question_text', 'type', 'weight'];

    public function category()
    {
        // TAMBAHKAN 'category_id'
        return $this->belongsTo(SurveyCategory::class, 'category_id');
    }

    public function options()
    {
        return $this->hasMany(SurveyQuestionOption::class, 'question_id');
    }
}
