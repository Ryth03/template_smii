<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class potentialHazardsInWorkplace_master extends Model
{
    protected $table = 'potentialHazardsInWorkplace_master';
    protected $fillable = ["name"];
    public $timestamps = false;
}
