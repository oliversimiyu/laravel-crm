<x-app-layout>
    <!-- Main Content -->
    <div class="w-full">
        <!-- Stats Overview -->
        <div class="stats-grid">
            <!-- Companies Card -->
            <div class="card">
                <div class="icon-wrapper blue-bg">
                    <span class="icon blue-text">C</span>
                </div>
                <h3 class="card-title">Companies</h3>
                <p class="card-value">{{ number_format($stats['companies'] ?? 0) }}</p>
            </div>

            <!-- Customers Card -->
            <div class="card">
                <div class="icon-wrapper green-bg">
                    <span class="icon green-text">U</span>
                </div>
                <h3 class="card-title">Customers</h3>
                <p class="card-value">{{ number_format($stats['customers'] ?? 0) }}</p>
            </div>

            <!-- Leads Card -->
            <div class="card">
                <div class="icon-wrapper orange-bg">
                    <span class="icon orange-text">L</span>
                </div>
                <h3 class="card-title">Leads</h3>
                <p class="card-value">{{ number_format($stats['leads'] ?? 0) }}</p>
            </div>

            <!-- Revenue Card -->
            <div class="card">
                <div class="icon-wrapper blue-bg">
                    <span class="icon blue-text">$</span>
                </div>
                <h3 class="card-title">Revenue</h3>
                <p class="card-value">${{ number_format($stats['revenue'] ?? 0) }}</p>
            </div>
        </div>

        <!-- New Consent & Recent Activity -->
        <div class="grid-2-1">
            <!-- New Consent -->
            <div class="card">
                <h2 class="section-title">New consent</h2>
                <div class="action-grid">
                    <a href="{{ route('customers.create') }}" class="action-card blue-card">
                        <div class="action-icon">
                            <span class="white-text">+U</span>
                        </div>
                        <div class="action-text">
                            <h3>New Customer</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                    <a href="{{ route('companies.create') }}" class="action-card teal-card">
                        <div class="action-icon">
                            <span class="white-text">+C</span>
                        </div>
                        <div class="action-text">
                            <h3>New Company</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                    <a href="{{ route('leads.create') }}" class="action-card indigo-card">
                        <div class="action-icon">
                            <span class="white-text">+L</span>
                        </div>
                        <div class="action-text">
                            <h3>New Lead</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                    <a href="{{ route('sales.create') }}" class="action-card purple-card">
                        <div class="action-icon">
                            <span class="white-text">+S</span>
                        </div>
                        <div class="action-text">
                            <h3>New Sale</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <h2 class="section-title">Recent Activity</h2>
                <div class="activity-list">
                    @forelse($recentActivities ?? [] as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <span class="white-text">A</span>
                            </div>
                            <div class="activity-text">
                                <p class="activity-title">New activity</p>
                                <p class="activity-time">{{ \Carbon\Carbon::parse($activity['created_at'] ?? now())->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="activity-item">
                            <div class="activity-icon">
                                <span class="white-text">U</span>
                            </div>
                            <div class="activity-text">
                                <p class="activity-title">New activity</p>
                                <p class="activity-time">2 minutes ago</p>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <span class="white-text">C</span>
                            </div>
                            <div class="activity-text">
                                <p class="activity-title">New activity</p>
                                <p class="activity-time">10 minutes ago</p>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <span class="white-text">→</span>
                            </div>
                            <div class="activity-text">
                                <p class="activity-title">New activity</p>
                                <p class="activity-time">3 hour ago</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
