<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasSlug, InteractsWithMedia;

    protected $appends = [
        'featured_image',
        'thumbnail_url',
        'image_urls'
    ];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'featured',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'featured' => 'boolean',
    ];

    protected static function booted()
    {
        // Clean up media when permanently deleting
        static::forceDeleted(function ($post) {
            $post->clearMediaCollection('thumbnail');
            $post->clearMediaCollection('gallery');
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->sharpen(10);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
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

    public function getImageUrlsAttribute()
    {
        $media = $this->getFirstMedia('thumbnail');
        if (!$media) {
            return null;
        }
        
        // Use the media's file path relative to storage/app/public
        $pathGenerator = app(config('media-library.path_generator'));
        $directory = $pathGenerator->getPath($media);
        $relativePath = $directory . $media->file_name;
        $originalUrl = asset('storage/' . $relativePath);
        
        return [
            'original' => $originalUrl,
            'medium' => $originalUrl, // For now, use original since conversions might not be generated
            'thumb' => $originalUrl,  // For now, use original since conversions might not be generated
        ];
    }

    protected function getConversionUrl($media, $conversion)
    {
        try {
            $path = $media->getPath($conversion);
            $relativePath = str_replace(storage_path('app/public/'), '', $path);
            return asset('storage/' . $relativePath);
        } catch (\Exception $e) {
            // Fallback to original if conversion fails
            $pathGenerator = app(config('media-library.path_generator'));
            $directory = $pathGenerator->getPath($media);
            $relativePath = $directory . $media->file_name;
            return asset('storage/' . $relativePath);
        }
    }
}