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
    public function getRankLabelAttribute()
    {
        $score = $this->total_score;

        if ($score >= 86) return 'Sekolah Unggul Digital';
        if ($score >= 76) return 'Sekolah Maju';
        if ($score >= 51) return 'Sekolah Berkembang';
        if ($score >= 31) return 'Sekolah Pemula';
        return 'Gagal';
    }
    public function getRankColorAttribute()
    {
        $score = $this->total_score;

        if ($score >= 86) return 'bg-cyan-100 text-cyan-700 border-cyan-200';
        if ($score >= 76) return 'bg-slate-100 text-slate-700 border-slate-300';
        if ($score >= 51) return 'bg-yellow-100 text-yellow-700 border-yellow-200';
        if ($score >= 31) return 'bg-gray-100 text-gray-600 border-gray-200';
        return 'bg-red-100 text-red-700 border-red-200';
    }
    public function getRankIconAttribute()
    {
        $score = $this->total_score;

        if ($score >= 86) return 'bi-gem';
        if ($score >= 76) return 'bi-trophy-fill';
        if ($score >= 51) return 'bi-award-fill';
        if ($score >= 31) return 'bi-star-fill';
        return 'bi-x-circle-fill';
    }
}
