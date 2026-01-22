<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdSpace;

class AdController extends Controller
{
    public function position($position)
    {
        $ads = AdSpace::active()
            ->byPosition($position)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $ads
        ]);
    }
}