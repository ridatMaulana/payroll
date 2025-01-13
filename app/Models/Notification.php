<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Notification extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'id',
        'status',
        'keterangan',
        'gajis_id'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function gaji(): BelongsTo
    {
        return $this->belongsTo(Gaji::class, 'gajis_id');
    }
}
