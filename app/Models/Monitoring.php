<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'monitoring';

    protected $primaryKey = 'id_monitoring';

    protected $fillable = [
        'id_wilayah',
        'id_bencana',
        'tanggal',
        'tingkat_ancaman',
        'tingkat_kerentanan',
        'kapasitas',
        'tingkat_risiko',
        'tingkat_kesiapsiagaan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function jenisBencana(): BelongsTo
    {
        return $this->belongsTo(JenisBencana::class, 'id_bencana', 'id_bencana');
    }

    public function monitoringIndikator(): HasMany
    {
        return $this->hasMany(MonitoringIndikator::class, 'id_monitoring', 'id_monitoring');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
