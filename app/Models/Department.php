<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // use HasFactory;
    use HasUuids;
    protected $table = 'departments';
    protected $fillable = [
        'name',
    ];
}
