<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Simulasi extends Model
{
    use HasFactory;

    protected $table = 'simulasi';

    protected $primaryKey = 'id_simulasi';

    protected $fillable = [
        'id_user',
        'jenis_simulasi',
        'nama_skenario',
        'parameter',
        'hasil_ringkas',
        'status',
    ];

    protected $casts = [
        'parameter' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis_simulasi', $jenis);
    }

    /**
     * Hapus riwayat simulasi secara aman berdasarkan ID dan kepemilikan user.
     */
    public static function hapusMilikUser($idSimulasi, $userId)
    {
        $simulasi = self::where('id_simulasi', $idSimulasi)
                        ->where('id_user', $userId)
                        ->firstOrFail();

        return $simulasi->delete();
    }
}