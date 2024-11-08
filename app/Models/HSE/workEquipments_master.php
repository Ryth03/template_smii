<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workEquipments_master extends Model
{
    protected $table = 'workEquipments_master';
    protected $fillable = ["name"];
    public $timestamps = false;
}
