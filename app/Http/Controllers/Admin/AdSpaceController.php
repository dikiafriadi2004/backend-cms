<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdSpace;
use Illuminate\Http\Request;

class AdSpaceController extends Controller
{
    public function index()
    {
        $adSpaces = AdSpace::latest()->paginate(15);
        return view('admin.ads.index', compact('adSpaces'));
    }

    public function create()
    {
        $positions = [
            'header' => 'Header',
            'sidebar' => 'Sidebar',
            'content_top' => 'Content Top',
            'content_middle' => 'Content Middle',
            'content_bottom' => 'Content Bottom',
            'footer' => 'Footer'
        ];

        $types = [
            'adsense' => 'Google AdSense',
            'manual' => 'Manual HTML/JS',
            'adsera' => 'Adsera'
        ];

        return view('admin.ads.create', compact('positions', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required',
            'position' => 'required',
            'type' => 'required|in:adsense,manual,adsera',
            'status' => 'required|boolean',
            'description' => 'nullable'
        ]);

        AdSpace::create($request->all());

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad Space berhasil dibuat.');
    }

    public function edit(AdSpace $ad)
    {
        $positions = [
            'header' => 'Header',
            'sidebar' => 'Sidebar',
            'content_top' => 'Content Top',
            'content_middle' => 'Content Middle',
            'content_bottom' => 'Content Bottom',
            'footer' => 'Footer'
        ];

        $types = [
            'adsense' => 'Google AdSense',
            'manual' => 'Manual HTML/JS',
            'adsera' => 'Adsera'
        ];

        return view('admin.ads.edit', compact('ad', 'positions', 'types'));
    }

    public function update(Request $request, AdSpace $ad)
    {
        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required',
            'position' => 'required',
            'type' => 'required|in:adsense,manual,adsera',
            'status' => 'required|boolean',
            'description' => 'nullable'
        ]);

        $ad->update($request->all());

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad Space berhasil diupdate.');
    }

    public function destroy(AdSpace $ad)
    {
        $ad->delete();
        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad Space berhasil dihapus.');
    }

    public function toggle(AdSpace $ad)
    {
        $ad->update(['status' => !$ad->status]);
        
        $status = $ad->status ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.ads.index')
            ->with('success', "Ad Space berhasil {$status}.");
    }
}