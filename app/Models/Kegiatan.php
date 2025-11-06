<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'department',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}