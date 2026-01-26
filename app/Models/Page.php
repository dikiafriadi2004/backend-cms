<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'template',
        'status',
        'sort_order',
        'show_in_menu',
        'is_homepage',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'user_id'
    ];

    protected $appends = [
        'featured_image'
    ];

    protected $casts = [
        'show_in_menu' => 'boolean',
        'is_homepage' => 'boolean',
    ];

    protected static function booted()
    {
        // Clean up media when permanently deleting
        static::forceDeleted(function ($page) {
            $page->clearMediaCollection('thumbnail');
            $page->clearMediaCollection('gallery');
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getThumbnailUrlAttribute()
    {
        $media = $this->getFirstMedia('thumbnail');
        if (!$media) {
            return null;
        }
        
        // Use the media's file path relative to storage/app/public
        $pathGenerator = app(config('media-library.path_generator'));
        $directory = $pathGenerator->getPath($media);
        $relativePath = $directory . $media->file_name;
        
        // Generate full URL using asset() helper
        return asset('storage/' . $relativePath);
    }

    public function getFeaturedImageAttribute()
    {
        $media = $this->getFirstMedia('thumbnail');
        if (!$media) {
            return null;
        }
        
        // Use the media's file path relative to storage/app/public
        $pathGenerator = app(config('media-library.path_generator'));
        $directory = $pathGenerator->getPath($media);
        $relativePath = $directory . $media->file_name;
        
        // Generate full URL using asset() helper
        return asset('storage/' . $relativePath);
    }
}