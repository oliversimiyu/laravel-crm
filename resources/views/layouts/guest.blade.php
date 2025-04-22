<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel CRM') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/crm-styles.css') }}" rel="stylesheet">
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-page">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-logo">
                    <div class="logo-text">CRM</div>
                </div>

                <div class="auth-content">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
