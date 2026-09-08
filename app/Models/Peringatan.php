<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peringatan extends Model
{
    use HasFactory;

    protected $table = 'peringatan';

    protected $primaryKey = 'id_peringatan';

    protected $fillable = [
        'id_kejadian',
        'id_wilayah',
        'jenis_peringatan',
        'tingkat',
        'pesan',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function kejadianBencana(): BelongsTo
    {
        return $this->belongsTo(KejadianBencana::class, 'id_kejadian', 'id_kejadian');
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTingkat($query, string $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }
}
