<x-app-layout>
    <div class="card">
        <h2 class="section-title">{{ __('Create Customer') }}</h2>
        
        <form method="POST" action="{{ route('customers.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div class="auth-form-group">
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <!-- Last Name -->
                <div class="auth-form-group">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>

                <!-- Company -->
                <div class="auth-form-group">
                    <x-input-label for="company_id" :value="__('Company')" />
                    <x-select id="company_id" name="company_id" class="mt-1 block w-full" required>
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('company_id')" />
                </div>

                <!-- Position -->
                <div class="auth-form-group">
                    <x-input-label for="position" :value="__('Position')" />
                    <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('position')" />
                </div>

                <!-- Email -->
                <div class="auth-form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Phone -->
                <div class="auth-form-group">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone')" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Notes -->
                <div class="auth-form-group md:col-span-2 mt-4">
                    <x-input-label for="notes" :value="__('Notes')" />
                    <x-textarea id="notes" name="notes" class="mt-1 block w-full">{{ old('notes') }}</x-textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <x-primary-button>
                    {{ __('Create Customer') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
