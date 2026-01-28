<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    // Di dalam file app/Models/School.php

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'jenjang',
        'npsn',
        'current_score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
