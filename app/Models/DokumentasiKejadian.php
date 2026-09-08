<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DokumentasiKejadian extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_kejadian';

    protected $primaryKey = 'id_dokumentasi';

    protected $fillable = [
        'id_kejadian',
        'id_user',
        'file_path',
        'nama_file',
        'caption',
        'sumber',
        'tanggal_pengambilan',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_pengambilan' => 'date',
    ];

    public function kejadianBencana(): BelongsTo
    {
        return $this->belongsTo(KejadianBencana::class, 'id_kejadian', 'id_kejadian');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function scopeTerverifikasi($query)
    {
        return $query->where('status_verifikasi', 'terverifikasi');
    }

    public function scopeBelumDiverifikasi($query)
    {
        return $query->where('status_verifikasi', 'belum diverifikasi');
    }

    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->file_path, 'http')) {
            return $this->file_path;
        }

        return Storage::url($this->file_path);
    }
}
