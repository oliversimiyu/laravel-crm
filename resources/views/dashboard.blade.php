@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <div class="w-full">
        <!-- Stats Overview -->
        <div class="stats-grid">
            <!-- Companies Card -->
            <div class="card">
                <div class="icon-wrapper blue-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 blue-text" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="card-title">Companies</h3>
                <p class="card-value">{{ number_format($stats['companies'] ?? 0) }}</p>
            </div>

            <!-- Customers Card -->
            <div class="card">
                <div class="icon-wrapper green-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 green-text" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="card-title">Customers</h3>
                <p class="card-value">{{ number_format($stats['customers'] ?? 0) }}</p>
            </div>

            <!-- Leads Card -->
            <div class="card">
                <div class="icon-wrapper orange-bg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 orange-text" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="card-title">Leads</h3>
                <p class="card-value">{{ number_format($stats['leads'] ?? 0) }}</p>
            </div>

            <!-- Revenue Card - Replaced with Livewire component -->
            @livewire('revenue-counter')
        </div>

        <div class="grid-2-1">
            <!-- New Consent -->
            <div class="card">
                <h2 class="section-title">New consent</h2>
                <div class="action-grid">
                    <a href="{{ route('customers.create') }}" class="action-card blue-card">
                        <div class="action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h3>New Customer</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                    <a href="{{ route('companies.create') }}" class="action-card teal-card">
                        <div class="action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h3>New Company</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                    <a href="{{ route('leads.create') }}" class="action-card indigo-card">
                        <div class="action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h3>New Lead</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                    <a href="{{ route('sales.create') }}" class="action-card purple-card">
                        <div class="action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h3>New Sale</h3>
                            <p>Create a new record</p>
                        </div>
                    </a>
                    <a href="{{ route('emails.compose') }}" class="action-card purple-card">
                        <div class="action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h3>Send Email</h3>
                            <p>Contact clients</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Activity - Replaced with Livewire component -->
            @livewire('recent-activities', ['isDashboard' => true])
        </div>
    </div>
@endsection
