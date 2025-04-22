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
                <a href="{{ route('dashboard') }}" class="navbar-brand">CRM Dashboard</a>
                
                <ul class="navbar-nav">
                    <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li><a href="{{ route('companies.index') }}" class="nav-link">Companies</a></li>
                    <li><a href="{{ route('customers.index') }}" class="nav-link">Customers</a></li>
                    <li><a href="{{ route('leads.index') }}" class="nav-link">Leads</a></li>
                    <li><a href="{{ route('communications.index') }}" class="nav-link">Communications</a></li>
                    <li><a href="{{ route('sales.index') }}" class="nav-link">Sales</a></li>
                    
                    <li class="dropdown">
                        <div class="user-dropdown">
                            <button class="dropdown-toggle" onclick="toggleDropdown()">
                                <span class="user-avatar">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                                <span>{{ Auth::user()->name ?? 'John Doe' }}</span>
                            </button>
                            <div class="dropdown-menu" id="userDropdown">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Page Content -->
            <main class="container py-8">
                {{ $slot }}
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
    </body>
</html>
