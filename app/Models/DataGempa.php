<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataGempa extends Model
{
    use HasFactory;

    protected $table = 'data_gempa';

    protected $primaryKey = 'id_gempa';

    protected $fillable = [
        'event_id',
        'id_sumber',
        'tanggal_waktu',
        'magnitudo',
        'kedalaman',
        'latitude',
        'longitude',
        'wilayah',
        'potensi_tsunami',
        'dirasakan',
        'sumber',
        'status_data',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'magnitudo' => 'float',
        'kedalaman' => 'float',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function sumberData(): BelongsTo
    {
        return $this->belongsTo(SumberData::class, 'id_sumber', 'id_sumber');
    }

    public function scopeTerbaru($query)
    {
        return $query->orderBy('tanggal_waktu', 'desc');
    }

    public function scopeWilayahPalu($query)
    {
        return $query->whereBetween('latitude', [-2.5, 0.5])
            ->whereBetween('longitude', [119.0, 121.5]);
    }
}
