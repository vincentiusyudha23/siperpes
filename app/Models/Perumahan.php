<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perumahan extends Model
{
    use HasFactory;

    protected $table = 'perumahans';

    protected $fillable = [
        'name_perum',
        'name_pengembangan',
        'desa',
        'kecamatan',
        'jumlah_unit',
        'tahun_berdiri',
        'geom',
        'easting',
        'norting',
        'lnglat',
        'luas_perumahan'
    ];
}
