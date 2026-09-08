<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataMukaLaut extends Model
{
    use HasFactory;

    protected $table = 'data_muka_laut';

    protected $primaryKey = 'id_data_laut';

    protected $fillable = [
        'id_sumber',
        'stasiun',
        'tanggal_waktu',
        'tinggi_muka_laut',
        'satuan',
        'jenis_data',
        'sumber',
        'status',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'tinggi_muka_laut' => 'float',
    ];

    public function sumberData(): BelongsTo
    {
        return $this->belongsTo(SumberData::class, 'id_sumber', 'id_sumber');
    }

    public function scopeTerbaru($query)
    {
        return $query->orderBy('tanggal_waktu', 'desc');
    }

    public function scopeJenisData($query, string $jenis)
    {
        return $query->where('jenis_data', $jenis);
    }
}
