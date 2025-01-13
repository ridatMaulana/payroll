<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Gaji extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'Bulan',
        'Tahun',
        'Gaji_pokok',
        'karyawans_id'
    ];

    public function gajiKomponen()
    {
        return $this->hasMany(GajiKomponen::class, 'gajis_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawans_id');
    }
}
