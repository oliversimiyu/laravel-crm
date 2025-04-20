<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $company->name }}
            </h2>
            <div>
                <a href="{{ route('companies.edit', $company) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit Company
                </a>
                <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this company?')">
                        Delete Company
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Company Details</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Industry</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $company->industry }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Website</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($company->website)
                                            <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                {{ $company->website }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $company->phone ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($company->email)
                                            <a href="mailto:{{ $company->email }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $company->email }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $company->address ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $company->notes ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Associated Data</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Customers</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('customers.index', ['company' => $company->id]) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $company->customers_count ?? 0 }} customers
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Active Leads</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('leads.index', ['company' => $company->id]) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $company->active_leads_count ?? 0 }} active leads
                                        </a>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                        <!-- Add recent activity content here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
