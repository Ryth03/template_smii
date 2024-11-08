<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class additionalWorkPermits_data extends Model
{
    use HasFactory;
    protected $table = 'additionalWorkPermits_data';
    protected $fillable = ["form_id", "master_id"];
    public $timestamps = false;
}
