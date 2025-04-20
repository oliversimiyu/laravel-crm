<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Communication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('communications.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <x-select id="type" name="type" class="mt-1 block w-full" required>
                                    <option value="">Select Type</option>
                                    <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="call" {{ old('type') == 'call' ? 'selected' : '' }}>Call</option>
                                    <option value="meeting" {{ old('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                                    <option value="note" {{ old('type') == 'note' ? 'selected' : '' }}>Note</option>
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>

                            <!-- Subject -->
                            <div>
                                <x-input-label for="subject" :value="__('Subject')" />
                                <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full" :value="old('subject')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('subject')" />
                            </div>

                            <!-- Related To -->
                            <div>
                                <x-input-label for="communicatable_type" :value="__('Related To')" />
                                <x-select id="communicatable_type" name="communicatable_type" class="mt-1 block w-full" required>
                                    <option value="">Select Type</option>
                                    <option value="App\Models\Customer" {{ old('communicatable_type') == 'App\Models\Customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="App\Models\Lead" {{ old('communicatable_type') == 'App\Models\Lead' ? 'selected' : '' }}>Lead</option>
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('communicatable_type')" />
                            </div>

                            <!-- Related ID -->
                            <div>
                                <x-input-label for="communicatable_id" :value="__('Select Contact')" />
                                <x-select id="communicatable_id" name="communicatable_id" class="mt-1 block w-full" required>
                                    <option value="">Select Contact</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" data-type="App\Models\Customer" {{ old('communicatable_id') == $customer->id && old('communicatable_type') == 'App\Models\Customer' ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }} (Customer)
                                        </option>
                                    @endforeach
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" data-type="App\Models\Lead" {{ old('communicatable_id') == $lead->id && old('communicatable_type') == 'App\Models\Lead' ? 'selected' : '' }}>
                                            {{ $lead->first_name }} {{ $lead->last_name }} (Lead)
                                        </option>
                                    @endforeach
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('communicatable_id')" />
                            </div>

                            <!-- Scheduled At -->
                            <div>
                                <x-input-label for="scheduled_at" :value="__('Scheduled At')" />
                                <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full" :value="old('scheduled_at')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('scheduled_at')" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <x-select id="status" name="status" class="mt-1 block w-full" required>
                                    <option value="">Select Status</option>
                                    <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </x-select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <!-- Content -->
                            <div class="md:col-span-2">
                                <x-input-label for="content" :value="__('Content')" />
                                <x-textarea id="content" name="content" class="mt-1 block w-full" required>{{ old('content') }}</x-textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('content')" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Notes')" />
                                <x-textarea id="notes" name="notes" class="mt-1 block w-full">{{ old('notes') }}</x-textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Communication') }}</x-primary-button>
                            <a href="{{ route('communications.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('communicatable_type');
            const idSelect = document.getElementById('communicatable_id');
            const options = Array.from(idSelect.options);

            typeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                
                // Hide all options first
                options.forEach(option => {
                    option.style.display = 'none';
                });

                // Show only options matching the selected type
                options.forEach(option => {
                    if (option.dataset.type === selectedType || option.value === '') {
                        option.style.display = '';
                    }
                });

                // Reset the selection
                idSelect.value = '';
            });

            // Trigger change event on page load if type is already selected
            if (typeSelect.value) {
                typeSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
    @endpush
</x-app-layout>
