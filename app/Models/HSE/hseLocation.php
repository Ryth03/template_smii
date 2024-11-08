<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hseLocation extends Model
{
    use HasFactory;
    protected $table = 'hse_locations';
    protected $fillable = [
        'name',
        'pic',
        'nik'
    ];
}
