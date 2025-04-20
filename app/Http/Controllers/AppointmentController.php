<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['creator', 'participants'])
            ->orderBy('start_time', 'asc')
            ->get();

        $calendarDays = collect();
        $startOfMonth = now()->startOfMonth();
        $daysInMonth = now()->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $startOfMonth->copy()->addDays($day - 1);
            $date->appointments = $appointments->filter(function ($appointment) use ($date) {
                return $appointment->start_time->isSameDay($date);
            });
            $calendarDays->push($date);
        }

        $tasks = Task::with(['assigned_to'])
            ->where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        $upcomingEvents = Appointment::upcoming()
            ->with(['creator', 'participants'])
            ->take(5)
            ->get();

        $users = User::all();

        return view('calendar.index', compact('calendarDays', 'tasks', 'upcomingEvents', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
