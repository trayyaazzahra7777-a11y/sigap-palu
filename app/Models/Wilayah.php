<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    // INI YANG PALING PENTING: Mencegah Laravel mencari tabel 'wilayahs'
    protected $table = 'wilayah';

    protected $primaryKey = 'id_wilayah'; // Custom Primary Key

    protected $fillable = [
        'nama_wilayah',
        'kecamatan',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id_wilayah', 'id_wilayah');
    }

    public function kejadianBencana()
    {
        return $this->hasMany(KejadianBencana::class, 'id_wilayah', 'id_wilayah');
    }

    public function peringatan()
    {
        return $this->hasMany(Peringatan::class, 'id_wilayah', 'id_wilayah');
    }
}
