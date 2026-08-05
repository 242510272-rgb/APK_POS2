<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    
    protected $fillable = [
        'user_id',
        'jenis_id', // Ditambahkan agar jenis bisa disimpan
        'foto',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Model Jenis
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }
    
    public function itemPenjualan()
    {
        return $this->hasMany(itemPenjualan::class, 'produk_id'); // Perbaikan typo: hasMany
    }
}