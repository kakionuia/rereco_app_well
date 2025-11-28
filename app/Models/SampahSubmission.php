<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampahSubmission extends Model
{
    use HasFactory;

    protected $table = 'sampah_submissions';

    protected $fillable = [
        'user_id','kurir_id','jenis', 'foto_path', 'deskripsi', 'estimated_weight', 'metode', 'status', 'points_awarded', 'reject_reason',
        'nama_pickup', 'alamat_pickup', 'tanggal_pickup', 'waktu_pickup', 'ekspedisi', 'ongkir',
        'berat_aktual', 'admin_message',
    ];

    /**
     * Cast timestamp fields to Carbon instances so ->format() and diffForHumans() work in views.
     */
    protected $casts = [
        'tanggal_pickup' => 'datetime',
        'waktu_pickup' => 'string',
        'dropoff_deadline' => 'datetime',
        'dropoff_confirmed_at' => 'datetime',
        'estimated_weight' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function kurir()
    {
        return $this->belongsTo(\App\Models\User::class, 'kurir_id');
    }
}
