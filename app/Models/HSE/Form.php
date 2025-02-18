<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status'
    ];

    public function projectExecutor()
    {
        return $this->hasOne(projectExecutor::class);
    }

    public function additionalWorkPermitsData()
    {
        return $this->hasMany(additionalWorkPermits_data::class);
    }
}
