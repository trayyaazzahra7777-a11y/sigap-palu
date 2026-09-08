<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBencana extends Model
{
    use HasFactory;

    // INI YANG PALING PENTING: Mencegah Laravel mencari tabel 'jenis_bencanas'
    protected $table = 'jenis_bencana';

    protected $primaryKey = 'id_bencana';

    protected $fillable = [
        'nama_bencana',
        'deskripsi',
    ];

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id_bencana', 'id_bencana');
    }

    public function kejadianBencana()
    {
        return $this->hasMany(KejadianBencana::class, 'id_bencana', 'id_bencana');
    }
}
