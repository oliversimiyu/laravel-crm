@extends('layouts.app')

@section('content')
    <div class="w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Activity Logs</h1>
            
            <div class="flex gap-2">
                <form action="{{ route('activities.index') }}" method="GET" class="flex gap-2">
                    <div class="form-group mb-0">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            @foreach($activityTypes as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mb-0">
                        <input type="text" name="search" class="form-input" placeholder="Search activities..." value="{{ request('search') }}">
                    </div>
                    
                    <button type="submit" class="action-button primary">Filter</button>
                </form>
            </div>
        </div>

        <!-- Use the Livewire component for the activities list with pagination -->
        @livewire('recent-activities', ['isDashboard' => false])
    </div>
@endsection
