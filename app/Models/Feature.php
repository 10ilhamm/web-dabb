<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'type',
        'parent_id',
        'path',
        'order',
        'content',
        'content_en',
    ];

    public function parent()
    {
        return $this->belongsTo(Feature::class, 'parent_id');
    }

    public function subfeatures()
    {
        return $this->hasMany(Feature::class, 'parent_id')->orderBy('order');
    }

    public function pages()
    {
        return $this->hasMany(FeaturePage::class)->orderBy('order');
    }
}
