<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'username',
        'domain_id',
    ];
}
