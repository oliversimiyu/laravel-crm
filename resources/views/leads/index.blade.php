<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Leads') }}
            </h2>
            <a href="{{ route('leads.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Lead</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('leads.index') }}" class="flex gap-4">
                            <div class="flex-1">
                                <x-input-label for="search" :value="__('Search')" />
                                <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Search by name or email..." />
                            </div>
                            <div class="flex-1">
                                <x-input-label for="company_id" :value="__('Filter by Company')" />
                                <x-select id="company_id" name="company_id" class="mt-1 block w-full">
                                    <option value="">All Companies</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="flex-1">
                                <x-input-label for="status" :value="__('Filter by Status')" />
                                <x-select id="status" name="status" class="mt-1 block w-full">
                                    <option value="">All Statuses</option>
                                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                    <option value="proposal" {{ request('status') == 'proposal' ? 'selected' : '' }}>Proposal</option>
                                    <option value="negotiation" {{ request('status') == 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                                    <option value="closed_won" {{ request('status') == 'closed_won' ? 'selected' : '' }}>Closed Won</option>
                                    <option value="closed_lost" {{ request('status') == 'closed_lost' ? 'selected' : '' }}>Closed Lost</option>
                                </x-select>
                            </div>
                            <div class="flex items-end">
                                <x-primary-button type="submit">
                                    {{ __('Filter') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Leads Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Source</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($leads as $lead)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $lead->first_name }} {{ $lead->last_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $lead->company->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span @class([
                                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-gray-100 text-gray-800' => $lead->status === 'new',
                                                'bg-blue-100 text-blue-800' => $lead->status === 'contacted',
                                                'bg-yellow-100 text-yellow-800' => $lead->status === 'qualified',
                                                'bg-purple-100 text-purple-800' => $lead->status === 'proposal',
                                                'bg-indigo-100 text-indigo-800' => $lead->status === 'negotiation',
                                                'bg-green-100 text-green-800' => $lead->status === 'closed_won',
                                                'bg-red-100 text-red-800' => $lead->status === 'closed_lost',
                                            ])>
                                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            ${{ number_format($lead->value, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $lead->source }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('leads.show', $lead) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">View</a>
                                            <a href="{{ route('leads.edit', $lead) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                            <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 ml-3" onclick="return confirm('Are you sure you want to delete this lead?')">
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
                        {{ $leads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
