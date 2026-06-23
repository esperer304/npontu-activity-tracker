<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActivityUpdateController extends Controller
{
    public function store(Request $request, Activity $activity): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(ActivityUpdate::STATUSES)],
            'remark' => ['required', 'string', 'max:1000'],
        ]);

        $activity->updates()->create([
            'user_id' => $request->user()->id,
            'status'  => $data['status'],
            'remark'  => $data['remark'],
        ]);

        return back()->with('status', 'Update logged.');
    }
}
