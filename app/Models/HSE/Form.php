<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'extend_from_form_id',
        'status'
    ];
    
}
