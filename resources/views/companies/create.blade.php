<x-app-layout>
    <div class="card">
        <h2 class="section-title">{{ __('Create Company') }}</h2>
        
        <form method="POST" action="{{ route('companies.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="auth-form-group">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Industry -->
                <div class="auth-form-group">
                    <x-input-label for="industry" :value="__('Industry')" />
                    <x-text-input id="industry" name="industry" type="text" :value="old('industry')" required />
                    <x-input-error :messages="$errors->get('industry')" />
                </div>

                <!-- Website -->
                <div class="auth-form-group">
                    <x-input-label for="website" :value="__('Website')" />
                    <x-text-input id="website" name="website" type="url" :value="old('website')" />
                    <x-input-error :messages="$errors->get('website')" />
                </div>

                <!-- Phone -->
                <div class="auth-form-group">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="tel" :value="old('phone')" />
                    <x-input-error :messages="$errors->get('phone')" />
                </div>

                <!-- Email -->
                <div class="auth-form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" :value="old('email')" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>
            </div>

            <!-- Address -->
            <div class="auth-form-group mt-4">
                <x-input-label for="address" :value="__('Address')" />
                <x-textarea id="address" name="address">{{ old('address') }}</x-textarea>
                <x-input-error :messages="$errors->get('address')" />
            </div>

            <!-- Notes -->
            <div class="auth-form-group mt-4">
                <x-input-label for="notes" :value="__('Notes')" />
                <x-textarea id="notes" name="notes">{{ old('notes') }}</x-textarea>
                <x-input-error :messages="$errors->get('notes')" />
            </div>

            <div class="flex justify-end mt-6">
                <x-primary-button>
                    {{ __('Create Company') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
