<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model',
        'serial_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}