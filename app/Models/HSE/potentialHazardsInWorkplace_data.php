<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class potentialHazardsInWorkplace_data extends Model
{
    use HasFactory;
    protected $table = 'potentialHazardsInWorkplace_data';
    protected $fillable = ["form_id", "master_id"];
    public $timestamps = false;
}
