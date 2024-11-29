<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobEvaluation extends Model
{
    use HasFactory;
    protected $fillable = ["form_id", "hse_rating", "engineering_rating", "total_rating"];
}
