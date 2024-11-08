<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class uploadFile extends Model
{
    use HasFactory;
    protected $table = 'uploadFiles';
    protected $fillable = ["form_id", "type", "file_name"];
    public $timestamps = false;
}
