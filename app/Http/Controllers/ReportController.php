<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->validatedFilters($request);

        $query = ActivityUpdate::query()
            ->with(['user:id,name,employee_id,department', 'activity:id,title'])
            ->whereBetween('created_at', [$filters['from']->startOfDay(), $filters['to']->endOfDay()])
            ->when($filters['activity_id'], fn ($q, $id) => $q->where('activity_id', $id))
            ->when($filters['user_id'], fn ($q, $id) => $q->where('user_id', $id))
            ->when($filters['status'], fn ($q, $s) => $q->where('status', $s))
            ->orderByDesc('created_at');

        $updates = $query->paginate(25)->withQueryString();

        $summary = [
            'total'   => (clone $query)->toBase()->getCountForPagination(),
            'done'    => (clone $query)->where('status', ActivityUpdate::STATUS_DONE)->toBase()->getCountForPagination(),
            'pending' => (clone $query)->where('status', ActivityUpdate::STATUS_PENDING)->toBase()->getCountForPagination(),
        ];

        return view('reports.index', [
            'filters'    => $filters,
            'updates'    => $updates,
            'summary'    => $summary,
            'activities' => Activity::orderBy('title')->get(['id', 'title']),
            'users'      => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = $this->validatedFilters($request);

        $filename = sprintf(
            'activity-report_%s_to_%s.csv',
            $filters['from']->toDateString(),
            $filters['to']->toDateString()
        );

        return response()->streamDownload(function () use ($filters) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Time', 'Activity', 'Status', 'Remark', 'Updated by', 'Employee ID', 'Department']);

            ActivityUpdate::with(['user:id,name,employee_id,department', 'activity:id,title'])
                ->whereBetween('created_at', [$filters['from']->startOfDay(), $filters['to']->endOfDay()])
                ->when($filters['activity_id'], fn ($q, $id) => $q->where('activity_id', $id))
                ->when($filters['user_id'], fn ($q, $id) => $q->where('user_id', $id))
                ->when($filters['status'], fn ($q, $s) => $q->where('status', $s))
                ->orderBy('created_at')
                ->chunk(500, function ($chunk) use ($out) {
                    foreach ($chunk as $u) {
                        fputcsv($out, [
                            $u->created_at->toDateString(),
                            $u->created_at->format('H:i'),
                            $u->activity->title ?? '—',
                            ucfirst($u->status),
                            $u->remark,
                            $u->user->name ?? '—',
                            $u->user->employee_id ?? '',
                            $u->user->department ?? '',
                        ]);
                    }
                });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function validatedFilters(Request $request): array
    {
        $data = $request->validate([
            'from'        => ['nullable', 'date'],
            'to'          => ['nullable', 'date', 'after_or_equal:from'],
            'activity_id' => ['nullable', 'integer', 'exists:activities,id'],
            'user_id'     => ['nullable', 'integer', 'exists:users,id'],
            'status'      => ['nullable', Rule::in(ActivityUpdate::STATUSES)],
        ]);

        return [
            'from'        => isset($data['from']) ? \Illuminate\Support\Carbon::parse($data['from']) : now()->subDays(7),
            'to'          => isset($data['to'])   ? \Illuminate\Support\Carbon::parse($data['to'])   : now(),
            'activity_id' => $data['activity_id'] ?? null,
            'user_id'     => $data['user_id'] ?? null,
            'status'      => $data['status'] ?? null,
        ];
    }
}
