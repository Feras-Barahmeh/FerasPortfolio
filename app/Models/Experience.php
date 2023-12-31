<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'admin_id',
        'organisation_url',
        'join_date',
        'leave_date',
    ];

    public array $translatedAttributes = [
        'name_organisation',
        'career_title',
        'job_description',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
