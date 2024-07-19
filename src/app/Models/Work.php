<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    /*
    public function scopeDateSearch($query, $work_date)
    {
        if (!empty($work_date)) {
            $query->whereDate('work_date', $work_date);
        }
    }*/
}
