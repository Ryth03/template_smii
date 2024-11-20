<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobSafetyAnalysis extends Model
{
    use HasFactory;
    protected $table = 'jobSafetyAnalysis';
    protected $fillable = [
        "form_id", 
        "work_step",
        "potential_danger",
        "risk_chance",
        "danger_control",
    ];
}
