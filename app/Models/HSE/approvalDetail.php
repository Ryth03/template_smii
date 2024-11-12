<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approvalDetail extends Model
{
    use HasFactory;
    protected $fillable = ["form_id", "approver_id", "status", "comment"];
}
