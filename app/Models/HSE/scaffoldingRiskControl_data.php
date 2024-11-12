<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class scaffoldingRiskControl_data extends Model
{
    use HasFactory;
    protected $table = 'scaffoldingRiskControl_data';
    protected $fillable = ["form_id", "master_id", "status"];
}
