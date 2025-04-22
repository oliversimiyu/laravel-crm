@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">{{ $communication->subject }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('communications.edit', $communication) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center" onclick="return confirm('Are you sure you want to delete this communication?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Communication Details -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="p-6 text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Communication Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Type</h4>
                                    <p class="text-white">{{ ucfirst($communication->type) }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Subject</h4>
                                    <p class="text-white">{{ $communication->subject }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Status</h4>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($communication->status === 'completed') bg-emerald-100 text-emerald-800
                                        @elseif($communication->status === 'planned') bg-amber-100 text-amber-800
                                        @else bg-rose-100 text-rose-800 @endif">
                                        {{ ucfirst($communication->status) }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Scheduled Date</h4>
                                    <p class="text-white">{{ $communication->scheduled_at ? $communication->scheduled_at->format('M d, Y g:i A') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Related Contact</h3>
                            <div class="space-y-4">
                                @if($communication->communicatable)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-400">Contact Type</h4>
                                        <p class="text-white">{{ class_basename($communication->communicatable_type) }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-400">Name</h4>
                                        @if($communication->communicatable_type === 'App\\Models\\Customer' || $communication->communicatable_type === 'App\\Models\\Lead')
                                            <p class="text-white">{{ $communication->communicatable->first_name }} {{ $communication->communicatable->last_name }}</p>
                                        @else
                                            <p class="text-white">{{ $communication->communicatable->name ?? 'N/A' }}</p>
                                        @endif
                                    </div>
                                    @if($communication->communicatable_type === 'App\\Models\\Customer')
                                        <div>
                                            <a href="{{ route('customers.show', $communication->communicatable->id) }}" class="text-blue-400 hover:text-blue-300">
                                                View Customer
                                            </a>
                                        </div>
                                    @elseif($communication->communicatable_type === 'App\\Models\\Lead')
                                        <div>
                                            <a href="{{ route('leads.show', $communication->communicatable->id) }}" class="text-blue-400 hover:text-blue-300">
                                                View Lead
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-gray-300">No related contact found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2 text-white">Content</h3>
                        <div class="bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-200 whitespace-pre-line">{{ $communication->content }}</p>
                        </div>
                    </div>
                    
                    @if($communication->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2 text-white">Notes</h3>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <p class="text-gray-200 whitespace-pre-line">{{ $communication->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
