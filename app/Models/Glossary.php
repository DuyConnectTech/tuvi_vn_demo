<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Glossary extends Model
{
    protected $fillable = [
        'term',
        'slug',
        'definition',
        'description',
        'category',
        'reference_url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->term);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('term') && empty($model->slug)) {
                $model->slug = Str::slug($model->term);
            }
        });
    }
}
