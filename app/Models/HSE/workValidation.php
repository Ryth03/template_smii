<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workValidation extends Model
{
    use HasFactory;
    protected $table = 'workValidations';
    protected $fillable = ["form_id", "hse_comply", "comments"];
}
