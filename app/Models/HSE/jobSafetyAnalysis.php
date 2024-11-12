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
        "job_name",
        "potential_danger",
        "danger_control",
    ];
}
