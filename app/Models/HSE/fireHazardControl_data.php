<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fireHazardControl_data extends Model
{
    use HasFactory;
    protected $table = 'fireHazardControl_data';
    protected $fillable = ["form_id", "master_id"];
    public $timestamps = false;
}
