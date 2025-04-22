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

        <div class="card">
            <div class="activity-list-full">
                @forelse($activities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon {{ $activity->color }}-bg">
                            <span class="white-text">{{ $activity->icon }}</span>
                        </div>
                        <div class="activity-text">
                            <div class="flex justify-between items-center mb-1">
                                <p class="activity-title">{{ $activity->subject }}</p>
                                <p class="activity-time">{{ $activity->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            @if($activity->description)
                                <p class="activity-description">{{ $activity->description }}</p>
                            @endif
                            <div class="activity-meta">
                                <span class="activity-type">{{ ucfirst($activity->type) }}</span>
                                @if($activity->user)
                                    <span class="activity-user">by {{ $activity->user->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>No activities found</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
@endsection
