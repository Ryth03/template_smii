<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workEquipments_data extends Model
{
    use HasFactory;
    protected $table = 'workEquipments_data';
    protected $fillable = ["form_id", "master_id"];
    public $timestamps = false;
}
