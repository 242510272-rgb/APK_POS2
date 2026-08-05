<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (opsional jika sesuai standar Laravel).
     */
    protected $table = 'jenis';

    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'nama_jenis',
        'user_id',
    ];

    /**
     * Relasi ke model Produk (Satu jenis memiliki banyak produk).
     */
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    /**
     * Relasi ke model User (Satu jenis dibuat oleh satu user).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}