<x-app-layout>
    <div class="card">
        <h2 class="section-title">{{ __('Create Sale') }}</h2>
        
        <form method="POST" action="{{ route('sales.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Invoice Number -->
                <div class="auth-form-group">
                    <x-input-label for="invoice_number" :value="__('Invoice Number')" />
                    <x-text-input id="invoice_number" name="invoice_number" type="text" class="mt-1 block w-full" :value="old('invoice_number')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('invoice_number')" />
                </div>

                <!-- Customer -->
                <div class="auth-form-group">
                    <x-input-label for="customer_id" :value="__('Customer')" />
                    <x-select id="customer_id" name="customer_id" class="mt-1 block w-full" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->company->name }})
                            </option>
                        @endforeach
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                </div>

                <!-- Amount -->
                <div class="auth-form-group">
                    <x-input-label for="amount" :value="__('Amount')" />
                    <x-text-input id="amount" name="amount" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('amount')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                </div>

                <!-- Date -->
                <div class="auth-form-group">
                    <x-input-label for="date" :value="__('Date')" />
                    <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('date')" />
                </div>

                <!-- Status -->
                <div class="auth-form-group">
                    <x-input-label for="status" :value="__('Status')" />
                    <x-select id="status" name="status" class="mt-1 block w-full" required>
                        <option value="">Select Status</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </x-select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <!-- Payment Method -->
                <div class="auth-form-group">
                    <x-input-label for="payment_method" :value="__('Payment Method')" />
                    <x-text-input id="payment_method" name="payment_method" type="text" class="mt-1 block w-full" :value="old('payment_method')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('payment_method')" />
                </div>

                <!-- Notes -->
                <div class="auth-form-group md:col-span-2">
                    <x-input-label for="notes" :value="__('Notes')" />
                    <x-textarea id="notes" name="notes" class="mt-1 block w-full">{{ old('notes') }}</x-textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                </div>
            </div>

            <div class="flex justify-end mt-6 gap-4">
                <x-primary-button>
                    {{ __('Create Sale') }}
                </x-primary-button>
                <a href="{{ route('sales.index') }}" class="auth-button bg-gray-600 hover:bg-gray-700">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
