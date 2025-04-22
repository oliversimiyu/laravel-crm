@extends('layouts.app')

@section('content')
    <div class="w-full">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ substr(Auth::user()->name ?? 'O', 0, 1) }}
            </div>
            <div class="profile-info">
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>

        <div class="card">
            <h2 class="section-title">{{ __('Profile Management') }}</h2>
            
            <div class="profile-grid">
                <!-- Profile Information -->
                <div class="profile-section">
                    <h3 class="subsection-title">{{ __('Profile Information') }}</h3>
                    <p class="text-gray-400 mb-4">{{ __('Update your account\'s profile information and email address.') }}</p>
                    @include('profile.partials.update-profile-information-form')
                </div>
                
                <!-- Update Password -->
                <div class="profile-section">
                    <h3 class="subsection-title">{{ __('Update Password') }}</h3>
                    <p class="text-gray-400 mb-4">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                    @include('profile.partials.update-password-form')
                </div>
                
                <!-- Delete Account -->
                <div class="profile-section border-t border-gray-700 pt-6 mt-6">
                    <h3 class="subsection-title text-red-400">{{ __('Delete Account') }}</h3>
                    <p class="text-gray-400 mb-4">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
