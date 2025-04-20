<x-app-layout>
    <div class="min-h-screen bg-gray-900">
        <!-- Top Navigation Bar -->
        <nav class="bg-gray-800 border-b border-gray-700">
            <div class="w-full px-6">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="text-xl font-bold text-white">CRM Dashboard</div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-150">
                            <i class="fas fa-plus mr-2"></i>New Entry
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="w-full px-6 py-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mx-0">
                <!-- Companies Card -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-500/10 rounded-lg">
                            <i class="fas fa-building text-blue-500 text-xl"></i>
                        </div>
                        <a href="{{ route('companies.create') }}" class="text-blue-500 hover:text-blue-400">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-1">{{ number_format($stats['companies'] ?? 0) }}</h3>
                    <p class="text-gray-400">Total Companies</p>
                </div>

                <!-- Customers Card -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-500/10 rounded-lg">
                            <i class="fas fa-users text-blue-500 text-xl"></i>
                        </div>
                        <a href="{{ route('customers.create') }}" class="text-blue-500 hover:text-blue-400">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-1">{{ number_format($stats['customers'] ?? 0) }}</h3>
                    <p class="text-gray-400">Total Customers</p>
                </div>

                <!-- Leads Card -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-500/10 rounded-lg">
                            <i class="fas fa-bullseye text-blue-500 text-xl"></i>
                        </div>
                        <a href="{{ route('leads.create') }}" class="text-blue-500 hover:text-blue-400">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-1">{{ number_format($stats['leads'] ?? 0) }}</h3>
                    <p class="text-gray-400">Active Leads</p>
                </div>

                <!-- Revenue Card -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-500/10 rounded-lg">
                            <i class="fas fa-dollar-sign text-blue-500 text-xl"></i>
                        </div>
                        <a href="{{ route('sales.create') }}" class="text-blue-500 hover:text-blue-400">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-1">${{ number_format($stats['revenue'] ?? 0) }}</h3>
                    <p class="text-gray-400">Total Revenue</p>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mx-0">
                <!-- Quick Actions -->
                <div class="lg:col-span-2 bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <h2 class="text-xl font-semibold text-white mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('customers.create') }}" class="flex items-center p-4 bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-150">
                            <div class="p-3 bg-blue-500/10 rounded-lg mr-4">
                                <i class="fas fa-user-plus text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-medium">New Customer</h3>
                                <p class="text-gray-400 text-sm">Add a new customer record</p>
                            </div>
                        </a>
                        <a href="{{ route('companies.create') }}" class="flex items-center p-4 bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-150">
                            <div class="p-3 bg-blue-500/10 rounded-lg mr-4">
                                <i class="fas fa-building text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-medium">New Company</h3>
                                <p class="text-gray-400 text-sm">Add a new company record</p>
                            </div>
                        </a>
                        <a href="{{ route('leads.create') }}" class="flex items-center p-4 bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-150">
                            <div class="p-3 bg-blue-500/10 rounded-lg mr-4">
                                <i class="fas fa-bullseye text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-medium">New Lead</h3>
                                <p class="text-gray-400 text-sm">Create a new lead</p>
                            </div>
                        </a>
                        <a href="{{ route('sales.create') }}" class="flex items-center p-4 bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-150">
                            <div class="p-3 bg-blue-500/10 rounded-lg mr-4">
                                <i class="fas fa-dollar-sign text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-medium">New Sale</h3>
                                <p class="text-gray-400 text-sm">Record a new sale</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                    <h2 class="text-xl font-semibold text-white mb-6">Recent Activity</h2>
                    <div class="space-y-4">
                        @forelse($recentActivities ?? [] as $activity)
                            <div class="flex items-center p-3 bg-gray-700 rounded-lg">
                                <div class="p-2 bg-blue-500/10 rounded-lg mr-3">
                                    <i class="fas fa-{{ $activity['type'] ?? 'circle' }} text-blue-500"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-white truncate">{{ $activity['description'] ?? 'New activity' }}</p>
                                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($activity['created_at'] ?? now())->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="p-3 bg-blue-500/10 rounded-lg inline-block mb-3">
                                    <i class="fas fa-stream text-blue-400 text-xl"></i>
                                </div>
                                <p class="text-gray-400">No recent activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
