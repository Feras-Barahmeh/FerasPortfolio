<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_skill',
    ];

    public $timestamps = false;
}
