<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class extendedFormLog extends Model
{
    use HasFactory;
    protected $fillable = [
        "form_id", 
        "start_date_before",
        "end_date_before",
        "start_date_after",
        "end_date_after",
        "status"
    ];
}
