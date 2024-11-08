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
        "potential_danger",
        "severity_before",
        "opportunity_before",
        "risk_factor_before",
        "danger_control",
        "severity_after",
        "opportunity_after",
        "risk_factor_after"
    ];
    public $timestamps = false;
}
