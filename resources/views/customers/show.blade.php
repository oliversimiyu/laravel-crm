<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $customer->first_name }} {{ $customer->last_name }}
            </h2>
            <div>
                <a href="{{ route('customers.edit', $customer) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit Customer
                </a>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this customer?')">
                        Delete Customer
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Customer Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Customer Details</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Company</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('companies.show', $customer->company) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $customer->company->name }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Position</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->position }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $customer->email }}
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->phone }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $customer->notes }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Statistics</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Active Leads</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('leads.index', ['customer' => $customer->id]) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $customer->active_leads_count }} leads
                                        </a>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Sales</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($customer->total_sales, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Pending Tasks</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ route('tasks.index', ['customer' => $customer->id]) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $customer->pending_tasks_count }} tasks
                                        </a>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div x-data="{ activeTab: 'leads' }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex">
                        <button @click="activeTab = 'leads'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'leads'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Leads
                        </button>
                        <button @click="activeTab = 'communications'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'communications'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Communications
                        </button>
                        <button @click="activeTab = 'tasks'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'tasks'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Tasks
                        </button>
                        <button @click="activeTab = 'sales'" :class="{'border-indigo-500 text-indigo-600': activeTab === 'sales'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Sales
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Leads Tab -->
                    <div x-show="activeTab === 'leads'">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Leads</h3>
                            <a href="{{ route('leads.create', ['customer' => $customer->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Add Lead
                            </a>
                        </div>
                        @include('customers.partials.leads-table', ['leads' => $customer->leads])
                    </div>

                    <!-- Communications Tab -->
                    <div x-show="activeTab === 'communications'">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Communications</h3>
                            <a href="{{ route('communications.create', ['customer' => $customer->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Add Communication
                            </a>
                        </div>
                        @include('customers.partials.communications-table', ['communications' => $customer->communications])
                    </div>

                    <!-- Tasks Tab -->
                    <div x-show="activeTab === 'tasks'">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Tasks</h3>
                            <a href="{{ route('tasks.create', ['customer' => $customer->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Add Task
                            </a>
                        </div>
                        @include('customers.partials.tasks-table', ['tasks' => $customer->tasks])
                    </div>

                    <!-- Sales Tab -->
                    <div x-show="activeTab === 'sales'">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Sales</h3>
                            <a href="{{ route('sales.create', ['customer' => $customer->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Add Sale
                            </a>
                        </div>
                        @include('customers.partials.sales-table', ['sales' => $customer->sales])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
