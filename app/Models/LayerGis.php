<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayerGis extends Model
{
    use HasFactory;

    protected $table = 'layer_gis';

    protected $primaryKey = 'id_layer';

    protected $fillable = [
        'nama_layer',
        'jenis_layer',
        'sumber',
        'format_data',
        'file_path',
        'status',
        'keterangan',
    ];

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
