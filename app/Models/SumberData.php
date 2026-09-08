<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SumberData extends Model
{
    use HasFactory;

    protected $table = 'sumber_data';

    protected $primaryKey = 'id_sumber';

    protected $fillable = [
        'nama_sumber',
        'jenis_data',
        'url_sumber',
        'tipe_sumber',
        'status',
        'last_update',
        'keterangan',
    ];

    protected $casts = [
        'last_update' => 'datetime',
    ];

    public function dataGempa(): HasMany
    {
        return $this->hasMany(DataGempa::class, 'id_sumber', 'id_sumber');
    }

    public function dataMukaLaut(): HasMany
    {
        return $this->hasMany(DataMukaLaut::class, 'id_sumber', 'id_sumber');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
