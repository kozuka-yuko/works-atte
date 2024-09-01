<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breaking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function work()
    {
        return $this->belongsTo(Work::class, 'work_id');
    }
}
