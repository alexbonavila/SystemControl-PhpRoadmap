<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reportable_id',
        'reportable_type',
        'format',
        'content'
    ];

    public function reportable()
    {
        return $this->morphTo();
    }
}
