@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">{{ $company->name }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('companies.edit', $company) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                        Edit Company
                    </a>
                    <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this company?')">
                            Delete Company
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="p-6 text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Company Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Name</h4>
                                    <p class="text-white">{{ $company->name }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Email</h4>
                                    <p class="text-white">{{ $company->email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Phone</h4>
                                    <p class="text-white">{{ $company->phone }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Website</h4>
                                    <p class="text-white">{{ $company->website }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Industry</h4>
                                    <p class="text-white">{{ $company->industry }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Address</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Street</h4>
                                    <p class="text-white">{{ $company->address_street }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">City</h4>
                                    <p class="text-white">{{ $company->address_city }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">State</h4>
                                    <p class="text-white">{{ $company->address_state }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Postal Code</h4>
                                    <p class="text-white">{{ $company->address_postal_code }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Country</h4>
                                    <p class="text-white">{{ $company->address_country }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-100">
                    <h3 class="text-lg font-semibold mb-4 text-white">Customers</h3>
                    @if($company->customers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Phone</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    @foreach($company->customers as $customer)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $customer->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                {{ $customer->phone }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('customers.show', $customer) }}" class="text-blue-400 hover:text-blue-300">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-300">No customers found for this company.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
