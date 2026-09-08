<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indikator extends Model
{
    use HasFactory;

    protected $table = 'indikator';

    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'nama_indikator',
        'kategori',
        'satuan',
        'bobot',
        'deskripsi',
    ];

    protected $casts = [
        'bobot' => 'float',
    ];

    public function monitoringIndikator(): HasMany
    {
        return $this->hasMany(MonitoringIndikator::class, 'id_indikator', 'id_indikator');
    }

    public function scopeKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
