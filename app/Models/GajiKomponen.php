<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GajiKomponen extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'Qty',
        'Sub_total',
        'gajis_id',
        'komponens_id',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function komponen()
    {
        return $this->belongsTo(Komponen::class, 'komponens_id');
    }

    public function gaji()
    {
        return $this->belongsTo(Gaji::class, 'gajis_id');
    }
}
