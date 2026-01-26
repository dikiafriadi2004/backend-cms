<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AdSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'description',
        'image_url',
        'link_url',
        'position',
        'type',
        'width',
        'height',
        'alt_text',
        'open_new_tab',
        'sort_order',
        'status',
        'start_date',
        'end_date',
        'click_count',
        'view_count',
        'code'
    ];

    protected $casts = [
        'status' => 'boolean',
        'open_new_tab' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'click_count' => 'integer',
        'view_count' => 'integer',
        'sort_order' => 'integer',
        'width' => 'integer',
        'height' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true)
                    ->where(function($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function isActive(): bool
    {
        if (!$this->status) {
            return false;
        }

        $now = now();
        
        if ($this->start_date && $this->start_date > $now) {
            return false;
        }

        if ($this->end_date && $this->end_date < $now) {
            return false;
        }

        return true;
    }

    public function isExpired(): bool
    {
        return $this->end_date && $this->end_date < now();
    }

    public function daysRemaining(): ?int
    {
        if (!$this->end_date) {
            return null;
        }

        $days = now()->diffInDays($this->end_date, false);
        return $days > 0 ? $days : 0;
    }

    // Methods
    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    public function incrementClicks(): void
    {
        $this->increment('click_count');
    }

    public function getClickThroughRate(): float
    {
        if ($this->view_count === 0) {
            return 0;
        }

        return round(($this->click_count / $this->view_count) * 100, 2);
    }

    // Constants for positions
    public const POSITIONS = [
        'header' => 'Header',
        'sidebar_top' => 'Sidebar Top',
        'sidebar_middle' => 'Sidebar Middle',
        'sidebar_bottom' => 'Sidebar Bottom',
        'content_top' => 'Content Top',
        'content_middle' => 'Content Middle',
        'content_bottom' => 'Content Bottom',
        'footer' => 'Footer',
        'between_posts' => 'Between Posts',
        'popup' => 'Popup',
        'mobile_banner' => 'Mobile Banner'
    ];

    // Constants for types
    public const TYPES = [
        'manual_banner' => 'Manual Banner',
        'manual_text' => 'Manual Text Link',
        'adsense' => 'Google AdSense',
        'adsera' => 'Adsera'
    ];

    // Standard banner sizes
    public const BANNER_SIZES = [
        'leaderboard' => ['width' => 728, 'height' => 90],
        'banner' => ['width' => 468, 'height' => 60],
        'half_banner' => ['width' => 234, 'height' => 60],
        'button' => ['width' => 125, 'height' => 125],
        'square' => ['width' => 250, 'height' => 250],
        'small_square' => ['width' => 200, 'height' => 200],
        'vertical_banner' => ['width' => 120, 'height' => 240],
        'rectangle' => ['width' => 300, 'height' => 250],
        'large_rectangle' => ['width' => 336, 'height' => 280],
        'mobile_banner' => ['width' => 320, 'height' => 50],
        'mobile_large' => ['width' => 320, 'height' => 100]
    ];
}