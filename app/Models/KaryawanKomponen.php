<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class KaryawanKomponen extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'Qty',
        'Sub_total',
        'karyawans_id',
        'komponens_id',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function komponen()
    {
        return $this->belongsTo(Komponen::class, 'komponens_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawans_id');
    }
}
