<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdSpaceController extends Controller
{
    public function index()
    {
        $adSpaces = AdSpace::with([])
            ->latest()
            ->paginate(10);
            
        return view('admin.ads.index', compact('adSpaces'));
    }

    public function create()
    {
        $positions = AdSpace::POSITIONS;
        $types = AdSpace::TYPES;
        $bannerSizes = AdSpace::BANNER_SIZES;

        return view('admin.ads.create', compact('positions', 'types', 'bannerSizes'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'title' => 'nullable|max:255',
            'description' => 'nullable|max:500',
            'position' => 'required|in:' . implode(',', array_keys(AdSpace::POSITIONS)),
            'type' => 'required|in:' . implode(',', array_keys(AdSpace::TYPES)),
            'link_url' => 'nullable|url|max:500',
            'alt_text' => 'nullable|max:255',
            'width' => 'nullable|integer|min:1|max:2000',
            'height' => 'nullable|integer|min:1|max:2000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
            'open_new_tab' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'code' => 'nullable|string'
        ];

        // Validasi khusus berdasarkan tipe
        if ($request->type === 'manual_banner') {
            $rules['image_url'] = 'required|url|max:500';
            $rules['width'] = 'required|integer|min:1|max:2000';
            $rules['height'] = 'required|integer|min:1|max:2000';
        } elseif (in_array($request->type, ['adsense', 'adsera'])) {
            $rules['code'] = 'required|string';
        }

        $request->validate($rules);

        $data = $request->only([
            'name', 'title', 'description', 'image_url', 'link_url',
            'position', 'type', 'width', 'height', 'alt_text',
            'open_new_tab', 'sort_order', 'status', 'start_date', 'end_date', 'code'
        ]);

        AdSpace::create($data);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Iklan berhasil dibuat.');
    }

    public function show(AdSpace $ad)
    {
        return view('admin.ads.show', compact('ad'));
    }

    public function edit(AdSpace $ad)
    {
        $positions = AdSpace::POSITIONS;
        $types = AdSpace::TYPES;
        $bannerSizes = AdSpace::BANNER_SIZES;

        return view('admin.ads.edit', compact('ad', 'positions', 'types', 'bannerSizes'));
    }

    public function update(Request $request, AdSpace $ad)
    {
        $rules = [
            'name' => 'required|max:255',
            'title' => 'nullable|max:255',
            'description' => 'nullable|max:500',
            'position' => 'required|in:' . implode(',', array_keys(AdSpace::POSITIONS)),
            'type' => 'required|in:' . implode(',', array_keys(AdSpace::TYPES)),
            'link_url' => 'nullable|url|max:500',
            'alt_text' => 'nullable|max:255',
            'width' => 'nullable|integer|min:1|max:2000',
            'height' => 'nullable|integer|min:1|max:2000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
            'open_new_tab' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'code' => 'nullable|string'
        ];

        // Validasi khusus berdasarkan tipe
        if ($request->type === 'manual_banner') {
            $rules['image_url'] = 'required|url|max:500';
            $rules['width'] = 'required|integer|min:1|max:2000';
            $rules['height'] = 'required|integer|min:1|max:2000';
        } elseif (in_array($request->type, ['adsense', 'adsera'])) {
            $rules['code'] = 'required|string';
        }

        $request->validate($rules);

        $data = $request->only([
            'name', 'title', 'description', 'image_url', 'link_url',
            'position', 'type', 'width', 'height', 'alt_text',
            'open_new_tab', 'sort_order', 'status', 'start_date', 'end_date', 'code'
        ]);

        $ad->update($data);

        return redirect()->route('admin.ads.index')
            ->with('success', 'Iklan berhasil diupdate.');
    }

    public function destroy(AdSpace $ad)
    {
        $ad->delete();
        
        return redirect()->route('admin.ads.index')
            ->with('success', 'Iklan berhasil dihapus.');
    }

    public function toggle(AdSpace $ad)
    {
        $ad->update(['status' => !$ad->status]);
        
        $status = $ad->status ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.ads.index')
            ->with('success', "Iklan berhasil {$status}.");
    }

    public function analytics(AdSpace $ad)
    {
        $analytics = [
            'total_views' => $ad->view_count,
            'total_clicks' => $ad->click_count,
            'click_through_rate' => $ad->getClickThroughRate(),
            'days_remaining' => $ad->daysRemaining(),
            'is_expired' => $ad->isExpired(),
            'is_active' => $ad->isActive()
        ];

        return view('admin.ads.analytics', compact('ad', 'analytics'));
    }
}