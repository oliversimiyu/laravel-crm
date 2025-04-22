<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel CRM') }}</title>

        <!-- Custom CRM Styles -->
        <link href="{{ asset('css/crm-styles.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen bg-gray-900">
            <!-- Custom Navigation -->
            <nav class="navbar">
                <a href="{{ route('dashboard') }}" class="navbar-brand">CRM</a>
                
                <div class="navbar-nav">
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">⌂</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('companies.index') }}" class="nav-item {{ request()->routeIs('companies.*') ? 'active' : '' }}">
                        <span class="nav-icon">C</span>
                        <span>Companies</span>
                    </a>
                    <a href="{{ route('customers.index') }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <span class="nav-icon">U</span>
                        <span>Customers</span>
                    </a>
                    <a href="{{ route('leads.index') }}" class="nav-item {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                        <span class="nav-icon">L</span>
                        <span>Leads</span>
                    </a>
                    <a href="{{ route('communications.index') }}" class="nav-item {{ request()->routeIs('communications.*') ? 'active' : '' }}">
                        <span class="nav-icon">@</span>
                        <span>Communications</span>
                    </a>
                    <a href="{{ route('sales.index') }}" class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                        <span class="nav-icon">$</span>
                        <span>Sales</span>
                    </a>
                    <a href="{{ route('invoices.index') }}" class="nav-item {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                        <span class="nav-icon">I</span>
                        <span>Invoices</span>
                    </a>
                    <a href="{{ route('quotes.index') }}" class="nav-item {{ request()->routeIs('quotes.*') ? 'active' : '' }}">
                        <span class="nav-icon">Q</span>
                        <span>Quotes</span>
                    </a>
                </div>
                
                <div class="navbar-right">
                    <a href="{{ route('emails.compose') }}" class="email-clients-btn">
                        <span>Email clients</span>
                    </a>
                    
                    <div class="user-dropdown">
                        <button class="dropdown-toggle" onclick="toggleDropdown()">
                            <span class="user-avatar">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                            <span class="user-name">{{ Auth::user()->name ?? 'User' }}</span>
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="container py-8">
                @yield('content')
            </main>
        </div>

        <script>
            function toggleDropdown() {
                const dropdown = document.getElementById('userDropdown');
                dropdown.classList.toggle('show');
            }

            // Close the dropdown if clicked outside
            window.onclick = function(event) {
                if (!event.target.matches('.dropdown-toggle') && 
                    !event.target.parentNode.matches('.dropdown-toggle')) {
                    const dropdowns = document.getElementsByClassName('dropdown-menu');
                    for (let i = 0; i < dropdowns.length; i++) {
                        const openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>
        
        @stack('scripts')
    </body>
</html>
