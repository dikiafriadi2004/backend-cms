<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdSpace;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Get ads by position
     */
    public function position($position)
    {
        $ads = AdSpace::active()
            ->byPosition($position)
            ->ordered()
            ->get()
            ->map(function ($ad) {
                // Increment view count
                $ad->incrementViews();
                
                return [
                    'id' => $ad->id,
                    'name' => $ad->name,
                    'title' => $ad->title,
                    'description' => $ad->description,
                    'image_url' => $ad->image_url,
                    'link_url' => $ad->link_url,
                    'type' => $ad->type,
                    'width' => $ad->width,
                    'height' => $ad->height,
                    'alt_text' => $ad->alt_text,
                    'open_new_tab' => $ad->open_new_tab,
                    'position' => $ad->position,
                    'code' => $ad->code
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $ads,
            'position' => $position
        ]);
    }

    /**
     * Get all active ads
     */
    public function index()
    {
        $ads = AdSpace::active()
            ->ordered()
            ->get()
            ->groupBy('position')
            ->map(function ($positionAds) {
                return $positionAds->map(function ($ad) {
                    return [
                        'id' => $ad->id,
                        'name' => $ad->name,
                        'title' => $ad->title,
                        'description' => $ad->description,
                        'image_url' => $ad->image_url,
                        'link_url' => $ad->link_url,
                        'type' => $ad->type,
                        'width' => $ad->width,
                        'height' => $ad->height,
                        'alt_text' => $ad->alt_text,
                        'open_new_tab' => $ad->open_new_tab,
                        'position' => $ad->position,
                        'code' => $ad->code
                    ];
                });
            });

        return response()->json([
            'success' => true,
            'data' => $ads
        ]);
    }

    /**
     * Track ad click
     */
    public function click(Request $request, $id)
    {
        $ad = AdSpace::find($id);
        
        if (!$ad) {
            return response()->json([
                'success' => false,
                'message' => 'Ad not found'
            ], 404);
        }

        // Increment click count
        $ad->incrementClicks();

        return response()->json([
            'success' => true,
            'message' => 'Click tracked successfully',
            'redirect_url' => $ad->link_url
        ]);
    }

    /**
     * Get ad analytics (for admin use)
     */
    public function analytics($id)
    {
        $ad = AdSpace::find($id);
        
        if (!$ad) {
            return response()->json([
                'success' => false,
                'message' => 'Ad not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $ad->id,
                'name' => $ad->name,
                'total_views' => $ad->view_count,
                'total_clicks' => $ad->click_count,
                'click_through_rate' => $ad->getClickThroughRate(),
                'days_remaining' => $ad->daysRemaining(),
                'is_expired' => $ad->isExpired(),
                'is_active' => $ad->isActive(),
                'start_date' => $ad->start_date,
                'end_date' => $ad->end_date
            ]
        ]);
    }

    /**
     * Get available positions
     */
    public function positions()
    {
        return response()->json([
            'success' => true,
            'data' => AdSpace::POSITIONS
        ]);
    }
}