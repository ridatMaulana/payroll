<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Karyawan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'no_induk',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'jabatan',
        'no_wa',
        'gaji_pokok',
        'users_id',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function karyawanKomponen()
    {
        return $this->hasMany(KaryawanKomponen::class, 'karyawans_id');
    }
}
