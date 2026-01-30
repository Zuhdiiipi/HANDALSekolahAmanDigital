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

    // 1. Label Peringkat (Teks)
    public function getRankLabelAttribute()
    {
        $score = $this->total_score;

        if ($score >= 86) return 'Sekolah Unggul Digital';
        if ($score >= 76) return 'Sekolah Maju';
        if ($score >= 51) return 'Sekolah Berkembang';
        if ($score >= 31) return 'Sekolah Pemula';
        return 'Gagal';
    }

    // 2. Warna Badge (Untuk UI)
    public function getRankColorAttribute()
    {
        $score = $this->total_score;

        if ($score >= 86) return 'bg-cyan-100 text-cyan-700 border-cyan-200'; // Diamond look
        if ($score >= 76) return 'bg-slate-100 text-slate-700 border-slate-300'; // Platinum
        if ($score >= 51) return 'bg-yellow-100 text-yellow-700 border-yellow-200'; // Gold
        if ($score >= 31) return 'bg-gray-100 text-gray-600 border-gray-200'; // Silver
        return 'bg-red-100 text-red-700 border-red-200'; // Gagal
    }

    // 3. Nama Logo (Untuk Icon)
    public function getRankIconAttribute()
    {
        $score = $this->total_score;

        if ($score >= 86) return 'bi-gem'; // Diamond
        if ($score >= 76) return 'bi-trophy-fill'; // Platinum
        if ($score >= 51) return 'bi-award-fill'; // Gold
        if ($score >= 31) return 'bi-star-fill'; // Silver
        return 'bi-x-circle-fill'; // Gagal
    }
}