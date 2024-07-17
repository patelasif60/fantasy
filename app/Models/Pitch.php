<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Pitch extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'is_published' => 'boolean',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 1080, 1578)
            ->performOnCollections('crest');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('crest')
            ->singleFile();
    }

    public function Teams()
    {
        return $this->hasMany(Team::class);
    }

    public function scopeIsPublished($query)
    {
        $query->where('is_published', true);
    }
}
