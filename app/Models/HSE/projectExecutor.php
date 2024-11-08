<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectExecutor extends Model
{
    use HasFactory;
    protected $table = 'projectExecutors';
    protected $fillable = 
    ["form_id",
    'company_department',
    'hp_number' ,
    'start_date' ,
    'end_date' ,
    'supervisor' ,
    'location' ,
    'start_time' ,
    'end_time' ,
    'workers_count' ,
    'work_description'];
    public $timestamps = false;
}
