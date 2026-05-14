<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Handover;
use App\Models\Lending;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'total_assets' => Asset::count(),
            'broken_assets' => Asset::where('broken', '>', 0)->count(),
            'obsolete_assets' => Asset::where('obsolete', 1)->count(),
            'active_lendings' => Lending::where('status', 'active')->count(),
            'total_handovers' => Handover::count(),
            'active_handovers' => Handover::where('status', 'active')->count(),
        ];

        $categoryStats = Asset::selectRaw('category, COUNT(*) as total, SUM(good) as good, SUM(broken) as broken')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $activelendings = Lending::with('asset')
            ->where('status', 'active')
            ->orderBy('due_date')
            ->limit(6)
            ->get();

        $recentHandovers = Handover::latest('handover_date')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'categoryStats', 'activelendings', 'recentHandovers'));
    }
}
