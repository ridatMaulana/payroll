<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Keluhan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'status',
        'keterangan',
        'alasan_ditolak',
        'gajis_id',
    ];


    protected $keyType = 'string';
    public $incrementing = false;

    public function gaji()
    {
        return $this->belongsTo(Gaji::class, 'gajis_id');
    }
}
