<?php
// app/Models/Kehadiran.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sesi_kehadiran_id',
        'user_latitude',
        'user_longitude',
        'status',
        'waktu_hadir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sesiKehadiran()
    {
        return $this->belongsTo(SesiKehadiran::class);
    }
}