<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'cpu',
        'ram',
        'storage'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
