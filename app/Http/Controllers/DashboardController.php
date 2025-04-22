<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Sale;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index(): View
    {
        // Calculate total revenue
        $totalRevenue = Sale::sum('amount');

        $stats = [
            'companies' => Company::count(),
            'customers' => Customer::count(),
            'leads' => Lead::count(),
            'revenue' => $totalRevenue,
        ];

        // Get recent activities (limited to 3)
        $recentActivities = $this->activityService->getRecent(3);

        return view('dashboard', compact('stats', 'recentActivities'));
    }

    public function reports(): View
    {
        // TODO: Implement reports view
        return view('reports');
    }

    public function profile(): View
    {
        return view('profile');
    }
}
