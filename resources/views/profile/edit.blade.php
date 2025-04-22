<x-app-layout>
    <div class="w-full">
        <div class="profile-section">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="profile-info">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <div class="card">
                <h2 class="section-title">{{ __('Profile Information') }}</h2>
                <p class="text-gray-400 mb-4">{{ __('Update your account\'s profile information and email address.') }}</p>
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="card">
                <h2 class="section-title">{{ __('Update Password') }}</h2>
                <p class="text-gray-400 mb-4">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                @include('profile.partials.update-password-form')
            </div>

            <div class="card">
                <h2 class="section-title">{{ __('Delete Account') }}</h2>
                <p class="text-gray-400 mb-4">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
