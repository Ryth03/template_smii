<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fitToWork extends Model
{
    use HasFactory;
    protected $table = 'fitToWork';
    protected $fillable = [
        "form_id", 
        "worker_name",
        "ok",
        "not_ok",
        "clinic_check",
        "clinic_recomendation"
    ];
    public $timestamps = false;
}
