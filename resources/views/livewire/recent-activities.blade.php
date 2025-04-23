<div wire:poll="{{ $pollingInterval }}ms" class="bg-gray-800 rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-white">Recent Activity</h2>
        @if($isDashboard)
            <a href="{{ route('activities.index') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
        @endif
    </div>
    
    <div class="space-y-4">
        @forelse($activities as $activity)
            <div class="flex items-start gap-3 pb-3 border-b border-gray-700">
                <div class="h-8 w-8 rounded-full bg-{{ $activity->color }}-600 flex items-center justify-center text-white flex-shrink-0">
                    <span class="text-sm">{{ $activity->icon }}</span>
                </div>
                <div>
                    <p class="text-gray-200">
                        {{ $activity->user ? $activity->user->name : 'System' }} 
                        
                        @if($activity->type == 'create')
                            created
                        @elseif($activity->type == 'update')
                            updated
                        @elseif($activity->type == 'delete')
                            deleted
                        @elseif($activity->type == 'email')
                            emailed
                        @elseif($activity->type == 'payment')
                            paid
                        @else
                            {{ $activity->type }}d
                        @endif
                        
                        @if(str_contains(strtolower($activity->loggable_type ?? ''), 'invoice'))
                            <span class="text-blue-400">Invoice</span>
                        @elseif(str_contains(strtolower($activity->loggable_type ?? ''), 'quote'))
                            <span class="text-green-400">Quote</span>
                        @else
                            {{ class_basename($activity->loggable_type ?? 'Item') }}
                        @endif
                        
                        "{{ Str::limit($activity->subject, 30) }}"
                    </p>
                    <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <div class="text-gray-400 text-center py-4">
                No recent activity found
            </div>
        @endforelse
    </div>
    
    @if(!$isDashboard && $activities instanceof \Illuminate\Pagination\LengthAwarePaginator && $activities->hasPages())
        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    @endif
</div>
