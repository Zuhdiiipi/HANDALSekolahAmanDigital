<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['school_id', 'year', 'total_score', 'status'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class);
    }
}