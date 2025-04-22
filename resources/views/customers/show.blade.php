@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">{{ $customer->first_name }} {{ $customer->last_name }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('customers.edit', $customer) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('emails.compose', ['customer_id' => $customer->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email
                    </a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center" onclick="return confirm('Are you sure you want to delete this customer?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="p-6 text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Customer Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Name</h4>
                                    <p class="text-white">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Email</h4>
                                    <p class="text-white">{{ $customer->email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Phone</h4>
                                    <p class="text-white">{{ $customer->phone }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Company</h4>
                                    <p class="text-white">
                                        @if($customer->company)
                                            <a href="{{ route('companies.show', $customer->company) }}" class="text-blue-400 hover:text-blue-300">
                                                {{ $customer->company->name }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Position</h4>
                                    <p class="text-white">{{ $customer->position ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Address</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Street</h4>
                                    <p class="text-white">{{ $customer->address_street ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">City</h4>
                                    <p class="text-white">{{ $customer->address_city ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">State</h4>
                                    <p class="text-white">{{ $customer->address_state ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Postal Code</h4>
                                    <p class="text-white">{{ $customer->address_postal_code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Country</h4>
                                    <p class="text-white">{{ $customer->address_country ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs for related data -->
            <div x-data="{ activeTab: 'leads' }" class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="border-b border-gray-700">
                    <nav class="-mb-px flex">
                        <button @click="activeTab = 'leads'" :class="{'border-blue-500 text-blue-400': activeTab === 'leads', 'border-transparent text-gray-400 hover:text-gray-300': activeTab !== 'leads'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Leads
                        </button>
                        <button @click="activeTab = 'sales'" :class="{'border-blue-500 text-blue-400': activeTab === 'sales', 'border-transparent text-gray-400 hover:text-gray-300': activeTab !== 'sales'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Sales
                        </button>
                        <button @click="activeTab = 'communications'" :class="{'border-blue-500 text-blue-400': activeTab === 'communications', 'border-transparent text-gray-400 hover:text-gray-300': activeTab !== 'communications'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Communications
                        </button>
                        <button @click="activeTab = 'invoices'" :class="{'border-blue-500 text-blue-400': activeTab === 'invoices', 'border-transparent text-gray-400 hover:text-gray-300': activeTab !== 'invoices'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Invoices
                        </button>
                    </nav>
                </div>
                <div class="p-6 text-gray-100">
                    <!-- Leads Tab -->
                    <div x-show="activeTab === 'leads'" class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white">Leads</h3>
                            <a href="{{ route('leads.create', ['customer_id' => $customer->id]) }}" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Add Lead</a>
                        </div>
                        @if($customer->leads->count() > 0)
                            <div class="overflow-x-auto">
                                @include('customers.partials.leads-table', ['leads' => $customer->leads])
                            </div>
                        @else
                            <p class="text-gray-300">No leads found for this customer.</p>
                        @endif
                    </div>

                    <!-- Sales Tab -->
                    <div x-show="activeTab === 'sales'" class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white">Sales</h3>
                            <a href="{{ route('sales.create', ['customer_id' => $customer->id]) }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Add Sale</a>
                        </div>
                        @if($customer->sales->count() > 0)
                            <div class="overflow-x-auto">
                                @include('customers.partials.sales-table', ['sales' => $customer->sales])
                            </div>
                        @else
                            <p class="text-gray-300">No sales found for this customer.</p>
                        @endif
                    </div>

                    <!-- Communications Tab -->
                    <div x-show="activeTab === 'communications'" class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white">Communications</h3>
                            <a href="{{ route('communications.create', ['customer_id' => $customer->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Add Communication</a>
                        </div>
                        @if($customer->communications->count() > 0)
                            <div class="overflow-x-auto">
                                @include('customers.partials.communications-table', ['communications' => $customer->communications])
                            </div>
                        @else
                            <p class="text-gray-300">No communications found for this customer.</p>
                        @endif
                    </div>

                    <!-- Invoices Tab -->
                    <div x-show="activeTab === 'invoices'" class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white">Invoices</h3>
                            <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Invoice</a>
                        </div>
                        @if($customer->invoices->count() > 0)
                            <div class="overflow-x-auto">
                                @include('customers.partials.invoices-table', ['invoices' => $customer->invoices])
                            </div>
                        @else
                            <p class="text-gray-300">No invoices found for this customer.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
