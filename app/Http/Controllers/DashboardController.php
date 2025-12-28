<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;

class DashboardController extends Controller
{
    public function index()
    {
        $rows = Interview::query()
            ->where('user_id', auth()->id())
            ->whereNotNull('self_confidence')
            ->orderBy('interview_date')
            ->get(['interview_date', 'self_confidence']);

        $labels = $rows->map(fn ($r) => $r->interview_date->format('Y-m-d'))->values();
        $values = $rows->map(fn ($r) => (int) $r->self_confidence)->values();

        $avg = $rows->count() ? round($rows->avg('self_confidence'), 1) : null;

        return view('dashboard', [
            'labels' => $labels,
            'values' => $values,
            'avgConfidence' => $avg,
            'totalReflections' => $rows->count(),
        ]);
    }
}
