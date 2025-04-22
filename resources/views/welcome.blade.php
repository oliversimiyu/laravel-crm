<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel CRM') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/crm-styles.css') }}" rel="stylesheet">
    </head>
    <body class="welcome-page">
        <div class="welcome-container">
            <header class="welcome-header">
                @if (Route::has('login'))
                    <nav class="welcome-nav">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="nav-button">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="nav-button">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-button primary">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="welcome-content">
                <div class="welcome-logo">
                    <div class="logo-text">CRM</div>
                </div>
                <h1>Welcome to Your CRM</h1>
                <p class="welcome-description">Manage your customers, leads, and sales with our powerful CRM system.</p>
                
                <div class="welcome-features">
                    <div class="feature-card">
                        <div class="feature-icon">C</div>
                        <h3>Companies</h3>
                        <p>Track and manage all your business clients</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">L</div>
                        <h3>Leads</h3>
                        <p>Never miss a sales opportunity</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">$</div>
                        <h3>Sales</h3>
                        <p>Monitor your revenue and performance</p>
                    </div>
                </div>

                <div class="welcome-cta">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="cta-button">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="cta-button">Get Started</a>
                    @endauth
                </div>
            </main>

            <footer class="welcome-footer">
                <p>&copy; {{ date('Y') }} Laravel CRM. All rights reserved.</p>
            </footer>
        </div>
    </body>
</html>
