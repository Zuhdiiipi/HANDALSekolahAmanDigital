<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'school_name',
        'jenjang',
        'province',
        'city',
        'district',
        'village',
        'address',
        'contact_number',
        'email',
        'npsn',
        'assessment_letter',
        'status'
    ];
}