<x-app-layout>
    <div class="card">
        <h2 class="section-title">{{ __('Create Lead') }}</h2>
        
        <form method="POST" action="{{ route('leads.store') }}" class="space-y-6">
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
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Source -->
                <div class="auth-form-group">
                    <x-input-label for="source" :value="__('Source')" />
                    <x-text-input id="source" name="source" type="text" class="mt-1 block w-full" :value="old('source')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('source')" />
                </div>

                <!-- Value -->
                <div class="auth-form-group">
                    <x-input-label for="value" :value="__('Value')" />
                    <x-text-input id="value" name="value" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('value')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('value')" />
                </div>

                <!-- Status -->
                <div class="auth-form-group">
                    <x-input-label for="status" :value="__('Status')" />
                    <x-select id="status" name="status" class="mt-1 block w-full" required>
                        <option value="">Select Status</option>
                        <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                        <option value="proposal" {{ old('status') == 'proposal' ? 'selected' : '' }}>Proposal</option>
                        <option value="negotiation" {{ old('status') == 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                        <option value="closed_won" {{ old('status') == 'closed_won' ? 'selected' : '' }}>Closed Won</option>
                        <option value="closed_lost" {{ old('status') == 'closed_lost' ? 'selected' : '' }}>Closed Lost</option>
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <!-- Notes -->
                <div class="auth-form-group md:col-span-2">
                    <x-input-label for="notes" :value="__('Notes')" />
                    <x-textarea id="notes" name="notes" class="mt-1 block w-full">{{ old('notes') }}</x-textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <x-primary-button>
                    {{ __('Create Lead') }}
                </x-primary-button>
                <a href="{{ route('leads.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
