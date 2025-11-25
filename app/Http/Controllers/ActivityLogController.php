<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $this->authorize('isAdmin');
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $activity_log)
    {
        $this->authorize('isAdmin');
        return view('activity_logs.show', compact('activity_log'));
    }

    public function destroy(ActivityLog $activity_log)
    {
        $this->authorize('isAdmin');
        $activity_log->delete();
        return redirect()->route('activity_logs.index')->with('success','Log dihapus.');
    }
}
