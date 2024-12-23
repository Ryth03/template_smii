<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class extendedFilesLog extends Model
{
    use HasFactory;
    protected $fillable = [
        "extended_id", 
        "form_id", 
        "type",
        "file_location",
        "file_name_before",
        "file_name_after"
    ];
}
