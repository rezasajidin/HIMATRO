<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'title',
        'short_description',
        'full_description',
        'day_date',
        'time',
        'location',
        'closing',
    ];

    protected $casts = [
        'day_date' => 'date',
        'time' => 'datetime:H:i',
    ];
}