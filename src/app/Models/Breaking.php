<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breaking extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    protected $primaryKey = 'work_id';


    public function Work()
    {
        return $this->belongsTo(Work::class);
    }
}
