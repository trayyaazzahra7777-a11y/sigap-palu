<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KejadianBencana extends Model
{
    use HasFactory;

    protected $table = 'kejadian_bencana';

    protected $primaryKey = 'id_kejadian';

    protected $fillable = [
        'id_wilayah',
        'id_bencana',
        'tanggal_waktu',
        'lokasi',
        'keterangan',
        'dampak',
        'status',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function jenisBencana(): BelongsTo
    {
        return $this->belongsTo(JenisBencana::class, 'id_bencana', 'id_bencana');
    }

    public function dokumentasiKejadian(): HasMany
    {
        return $this->hasMany(DokumentasiKejadian::class, 'id_kejadian', 'id_kejadian');
    }

    public function peringatan(): HasMany
    {
        return $this->hasMany(Peringatan::class, 'id_kejadian', 'id_kejadian');
    }

    public function scopeDiverifikasi($query)
    {
        return $query->where('status', 'diverifikasi');
    }

    public function scopeTercatat($query)
    {
        return $query->where('status', 'tercatat');
    }
}
