<?php

namespace App\Models\HSE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userHasApprover extends Model
{
    use HasFactory;
    protected $table = 'user_has_approvers';
    protected $fillable = ["approver_id", "user_id"];
}
