<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of all activities.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Activity::with(['user', 'loggable'])
            ->when($request->search, function ($query, $search) {
                $query->where('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            });

        $activities = $query->latest()->paginate(10); // Changed from 15 to 10 items per page
        
        // Get distinct activity types for filtering
        $activityTypes = Activity::distinct()->pluck('type')->toArray();

        return view('activities.index', compact('activities', 'activityTypes'));
    }
}
