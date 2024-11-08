<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testResult extends Model
{
    use HasFactory;
    protected $table = 'testResults';
    protected $fillable = [
        'form_id',
        'lel',
        'o2',
        'h2s',
        'co',
        'test_date',
    ];
    public $timestamps = false;
}
