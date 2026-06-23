<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::with(['creator:id,name', 'latestUpdate.user:id,name'])
            ->orderByDesc('is_active')
            ->orderBy('title')
            ->paginate(20);

        return view('activities.index', compact('activities'));
    }

    public function create(): View
    {
        return view('activities.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active'   => ['sometimes', 'boolean'],
        ]);

        $data['created_by'] = $request->user()->id;
        $data['is_active'] = $request->boolean('is_active', true);

        Activity::create($data);

        return redirect()->route('activities.index')->with('status', 'Activity created.');
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active'   => ['sometimes', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', false);
        $activity->update($data);

        return redirect()->route('activities.index')->with('status', 'Activity updated.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->update(['is_active' => false]);

        return redirect()->route('activities.index')->with('status', 'Activity archived.');
    }
}
