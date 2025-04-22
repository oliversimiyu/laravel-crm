@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Communications</h1>
                <a href="{{ route('communications.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Create Communication
                </a>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-100">
                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('communications.index') }}" class="flex gap-4">
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-300">Search</label>
                                <input id="search" name="search" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ request('search') }}" placeholder="Search communications...">
                            </div>
                            <div class="flex-1">
                                <label for="type" class="block text-sm font-medium text-gray-300">Type</label>
                                <select id="type" name="type" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                                    <option value="">All Types</option>
                                    <option value="email" {{ request('type') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="call" {{ request('type') == 'call' ? 'selected' : '' }}>Call</option>
                                    <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                                    <option value="note" {{ request('type') == 'note' ? 'selected' : '' }}>Note</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label for="contact_type" class="block text-sm font-medium text-gray-300">Contact Type</label>
                                <select id="contact_type" name="contact_type" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                                    <option value="">All Contacts</option>
                                    <option value="customer" {{ request('contact_type') == 'customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="lead" {{ request('contact_type') == 'lead' ? 'selected' : '' }}>Lead</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Customer/Lead</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @foreach($communications as $communication)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($communication->type == 'email') bg-blue-100 text-blue-800
                                                @elseif($communication->type == 'call') bg-green-100 text-green-800
                                                @elseif($communication->type == 'meeting') bg-purple-100 text-purple-800
                                                @elseif($communication->type == 'note') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($communication->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            @if($communication->customer_id)
                                                <span class="text-green-400">Customer:</span> {{ $communication->customer->first_name }} {{ $communication->customer->last_name }}
                                            @elseif($communication->lead_id)
                                                <span class="text-orange-400">Lead:</span> {{ $communication->lead->first_name }} {{ $communication->lead->last_name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $communication->subject }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $communication->date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('communications.show', $communication) }}" class="text-blue-400 hover:text-blue-300">View</a>
                                                <a href="{{ route('communications.edit', $communication) }}" class="text-yellow-400 hover:text-yellow-300">Edit</a>
                                                <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this communication?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $communications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
