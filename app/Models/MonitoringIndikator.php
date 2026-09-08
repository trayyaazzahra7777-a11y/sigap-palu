<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringIndikator extends Model
{
    use HasFactory;

    protected $table = 'monitoring_indikator';

    protected $primaryKey = 'id_monitoring_indikator';

    protected $fillable = [
        'id_monitoring',
        'id_indikator',
        'nilai',
        'status_indikator',
    ];

    protected $casts = [
        'nilai' => 'float',
    ];

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(Monitoring::class, 'id_monitoring', 'id_monitoring');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator', 'id_indikator');
    }
}
