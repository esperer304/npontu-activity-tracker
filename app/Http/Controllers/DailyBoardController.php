<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DailyBoardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $date = $request->date('date')?->startOfDay() ?? now()->startOfDay();

        $activities = Activity::where('is_active', true)
            ->with(['creator:id,name'])
            ->orderBy('title')
            ->get();

        $updatesToday = ActivityUpdate::with(['user:id,name,employee_id,department', 'activity:id,title'])
            ->whereDate('created_at', $date)
            ->orderByDesc('created_at')
            ->get();

        $latestByActivity = $updatesToday->groupBy('activity_id')->map->first();

        $stats = [
            'total'   => $activities->count(),
            'done'    => $latestByActivity->where('status', ActivityUpdate::STATUS_DONE)->count(),
            'pending' => $latestByActivity->where('status', ActivityUpdate::STATUS_PENDING)->count(),
            'logged'  => $updatesToday->count(),
        ];

        return view('board.index', [
            'date'             => $date,
            'activities'       => $activities,
            'updatesToday'     => $updatesToday,
            'latestByActivity' => $latestByActivity,
            'stats'            => $stats,
        ]);
    }
}
