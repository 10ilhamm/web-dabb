<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturePageSection extends Model
{
    protected $fillable = [
        'feature_page_id',
        'title',
        'title_en',
        'description',
        'description_en',
        'images',
        'order',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function featurePage()
    {
        return $this->belongsTo(FeaturePage::class);
    }
}
