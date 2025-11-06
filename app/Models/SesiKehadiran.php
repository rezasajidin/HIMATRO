<?php
// app/Models/SesiKehadiran.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiKehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'event_name',
        'token',
        'latitude',
        'longitude',
        'radius',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }
}