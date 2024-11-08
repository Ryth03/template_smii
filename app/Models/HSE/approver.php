<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approver extends Model
{
    use HasFactory;
    protected $table = 'approvers';
    protected $fillable = ["name", "level"];
}
