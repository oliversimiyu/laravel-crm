<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['companies'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Companies</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-emerald-600">{{ $stats['customers'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Customers</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-amber-600">{{ $stats['leads'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Leads</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-violet-600">{{ $stats['communications'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Communications</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-sky-600">{{ $stats['tasks'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Tasks</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-rose-600">{{ $stats['sales'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Sales</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Companies Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Companies</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Manage your companies</span>
                            <a href="{{ route('companies.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">View All</a>
                        </div>
                    </div>
                </div>

                <!-- Customers Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Customers</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Manage your customers</span>
                            <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">View All</a>
                        </div>
                    </div>
                </div>

                <!-- Leads Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Leads</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Track your leads</span>
                            <a href="{{ route('leads.index') }}" class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">View All</a>
                        </div>
                    </div>
                </div>

                <!-- Communications Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Communications</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Log communications</span>
                            <a href="{{ route('communications.index') }}" class="px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700">View All</a>
                        </div>
                    </div>
                </div>

                <!-- Tasks Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tasks</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Manage tasks</span>
                            <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700">View All</a>
                        </div>
                    </div>
                </div>

                <!-- Sales Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Sales</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Track sales</span>
                            <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-rose-600 text-white rounded-md hover:bg-rose-700">View All</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="mt-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Activities</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Recent Leads -->
                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Latest Leads</h4>
                                @forelse($recentActivities['leads'] as $lead)
                                    <div class="mb-2 p-2 bg-amber-50 dark:bg-amber-900 rounded">
                                        <div class="font-medium">{{ $lead->title }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $lead->created_at->diffForHumans() }}</div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No recent leads</p>
                                @endforelse
                            </div>

                            <!-- Recent Tasks -->
                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Latest Tasks</h4>
                                @forelse($recentActivities['tasks'] as $task)
                                    <div class="mb-2 p-2 bg-sky-50 dark:bg-sky-900 rounded">
                                        <div class="font-medium">{{ $task->title }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $task->created_at->diffForHumans() }}</div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No recent tasks</p>
                                @endforelse
                            </div>

                            <!-- Recent Communications -->
                            <div>
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Latest Communications</h4>
                                @forelse($recentActivities['communications'] as $communication)
                                    <div class="mb-2 p-2 bg-violet-50 dark:bg-violet-900 rounded">
                                        <div class="font-medium">{{ $communication->title }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $communication->created_at->diffForHumans() }}</div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No recent communications</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            <a href="{{ route('companies.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200">
                                New Company
                            </a>
                            <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-100 text-emerald-800 rounded-md hover:bg-emerald-200">
                                New Customer
                            </a>
                            <a href="{{ route('leads.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-100 text-amber-800 rounded-md hover:bg-amber-200">
                                New Lead
                            </a>
                            <a href="{{ route('communications.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-violet-100 text-violet-800 rounded-md hover:bg-violet-200">
                                New Communication
                            </a>
                            <a href="{{ route('tasks.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-sky-100 text-sky-800 rounded-md hover:bg-sky-200">
                                New Task
                            </a>
                            <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-rose-100 text-rose-800 rounded-md hover:bg-rose-200">
                                New Sale
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
