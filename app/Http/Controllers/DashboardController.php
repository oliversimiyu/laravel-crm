<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Communication;
use App\Models\Task;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'companies' => Company::count(),
            'customers' => Customer::count(),
            'leads' => Lead::count(),
            'communications' => Communication::count(),
            'tasks' => Task::count(),
            'sales' => Sale::count(),
        ];

        $recentActivities = [
            'leads' => Lead::latest()->take(5)->get(),
            'tasks' => Task::latest()->take(5)->get(),
            'communications' => Communication::latest()->take(5)->get(),
        ];

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
