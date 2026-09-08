<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogData extends Model
{
    use HasFactory;

    protected $table = 'log_data';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'sumber',
        'jenis_data',
        'waktu_update',
        'status_koneksi',
        'keterangan',
    ];

    protected $casts = [
        'waktu_update' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function scopeTerbaru($query)
    {
        return $query->orderBy('waktu_update', 'desc');
    }
}
