<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Communications') }}
            </h2>
            <a href="{{ route('communications.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Communication</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('communications.index') }}" class="flex gap-4">
                            <div class="flex-1">
                                <x-input-label for="search" :value="__('Search')" />
                                <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Search communications..." />
                            </div>
                            <div class="flex-1">
                                <x-input-label for="type" :value="__('Filter by Type')" />
                                <x-select id="type" name="type" class="mt-1 block w-full">
                                    <option value="">All Types</option>
                                    <option value="email" {{ request('type') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="call" {{ request('type') == 'call' ? 'selected' : '' }}>Call</option>
                                    <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                                    <option value="note" {{ request('type') == 'note' ? 'selected' : '' }}>Note</option>
                                </x-select>
                            </div>
                            <div class="flex-1">
                                <x-input-label for="status" :value="__('Filter by Status')" />
                                <x-select id="status" name="status" class="mt-1 block w-full">
                                    <option value="">All Statuses</option>
                                    <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </x-select>
                            </div>
                            <div class="flex items-end">
                                <x-primary-button type="submit">
                                    {{ __('Filter') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Communications Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer/Lead</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($communications as $communication)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span @class([
                                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-blue-100 text-blue-800' => $communication->type === 'email',
                                                'bg-green-100 text-green-800' => $communication->type === 'call',
                                                'bg-purple-100 text-purple-800' => $communication->type === 'meeting',
                                                'bg-gray-100 text-gray-800' => $communication->type === 'note',
                                            ])>
                                                {{ ucfirst($communication->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $communication->communicatable->full_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $communication->subject }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span @class([
                                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-yellow-100 text-yellow-800' => $communication->status === 'planned',
                                                'bg-green-100 text-green-800' => $communication->status === 'completed',
                                                'bg-red-100 text-red-800' => $communication->status === 'cancelled',
                                            ])>
                                                {{ ucfirst($communication->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $communication->scheduled_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('communications.show', $communication) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">View</a>
                                            <a href="{{ route('communications.edit', $communication) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                            <form action="{{ route('communications.destroy', $communication) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 ml-3" onclick="return confirm('Are you sure you want to delete this communication?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $communications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
