@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">{{ $lead->first_name }} {{ $lead->last_name }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('leads.edit', $lead) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('emails.compose', ['email' => $lead->email]) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email
                    </a>
                    <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center" onclick="return confirm('Are you sure you want to delete this lead?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lead Details -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="p-6 text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Lead Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Name</h4>
                                    <p class="text-white">{{ $lead->first_name }} {{ $lead->last_name }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Email</h4>
                                    <p class="text-white">{{ $lead->email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Phone</h4>
                                    <p class="text-white">{{ $lead->phone }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Position</h4>
                                    <p class="text-white">{{ $lead->position }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Additional Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Company</h4>
                                    <p class="text-white">{{ $lead->company->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Source</h4>
                                    <p class="text-white">{{ $lead->source }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Value</h4>
                                    <p class="text-white">KES {{ number_format($lead->value, 2) }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Status</h4>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($lead->status === 'active') bg-emerald-100 text-emerald-800
                                        @elseif($lead->status === 'pending') bg-amber-100 text-amber-800
                                        @else bg-rose-100 text-rose-800 @endif">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($lead->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2 text-white">Notes</h3>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <p class="text-gray-200">{{ $lead->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabs for Communications -->
            <div x-data="{ activeTab: 'communications' }" class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="border-b border-gray-700">
                    <nav class="-mb-px flex">
                        <button @click="activeTab = 'communications'" :class="{'border-blue-500 text-blue-400': activeTab === 'communications', 'border-transparent text-gray-400 hover:text-gray-300': activeTab !== 'communications'}" class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Communications
                        </button>
                        <button @click="activeTab = 'convert'" :class="{'border-blue-500 text-blue-400': activeTab === 'convert', 'border-transparent text-gray-400 hover:text-gray-300': activeTab !== 'convert'}" class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Convert to Customer
                        </button>
                    </nav>
                </div>
                
                <div class="p-6 text-gray-100">
                    <!-- Communications Tab -->
                    <div x-show="activeTab === 'communications'" class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white">Communications</h3>
                            <a href="{{ route('communications.create', ['lead_id' => $lead->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add Communication</a>
                        </div>
                        @if($lead->communications->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead class="bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Subject</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                                        @foreach($lead->communications as $communication)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-200">{{ ucfirst($communication->type) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-200">{{ $communication->subject }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-200">{{ $communication->scheduled_at->format('M d, Y') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($communication->status === 'completed') bg-emerald-100 text-emerald-800
                                                        @elseif($communication->status === 'scheduled') bg-amber-100 text-amber-800
                                                        @else bg-rose-100 text-rose-800 @endif">
                                                        {{ ucfirst($communication->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('communications.edit', $communication) }}" class="text-indigo-400 hover:text-indigo-300 mr-3">Edit</a>
                                                    <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-300">No communications found for this lead.</p>
                        @endif
                    </div>

                    <!-- Convert to Customer Tab -->
                    <div x-show="activeTab === 'convert'" class="space-y-4">
                        <h3 class="text-lg font-semibold text-white">Convert Lead to Customer</h3>
                        <p class="text-gray-300 mb-4">Convert this lead into a customer to track sales and other customer-specific information.</p>
                        
                        <form action="{{ route('leads.convert', $lead) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-300">Conversion Notes</label>
                                    <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" placeholder="Add any notes about this conversion..."></textarea>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="keep_lead" name="keep_lead" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded bg-gray-700">
                                    <label for="keep_lead" class="ml-2 block text-sm text-gray-300">Keep lead record after conversion</label>
                                </div>
                                
                                <div class="pt-4">
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Convert to Customer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
