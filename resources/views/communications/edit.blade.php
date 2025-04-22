@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Edit Communication</h1>
                <a href="{{ route('communications.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Back to Communications
                </a>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('communications.update', $communication) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-300">Type</label>
                                <select id="type" name="type" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Type</option>
                                    <option value="email" {{ old('type', $communication->type) == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="call" {{ old('type', $communication->type) == 'call' ? 'selected' : '' }}>Call</option>
                                    <option value="meeting" {{ old('type', $communication->type) == 'meeting' ? 'selected' : '' }}>Meeting</option>
                                    <option value="note" {{ old('type', $communication->type) == 'note' ? 'selected' : '' }}>Note</option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-300">Subject</label>
                                <input id="subject" name="subject" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('subject', $communication->subject) }}" required>
                                @error('subject')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Related To -->
                            <div>
                                <label for="communicatable_type" class="block text-sm font-medium text-gray-300">Related To</label>
                                <select id="communicatable_type" name="communicatable_type" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Type</option>
                                    <option value="App\Models\Customer" {{ old('communicatable_type', $communication->communicatable_type) == 'App\Models\Customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="App\Models\Lead" {{ old('communicatable_type', $communication->communicatable_type) == 'App\Models\Lead' ? 'selected' : '' }}>Lead</option>
                                </select>
                                @error('communicatable_type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Related ID -->
                            <div>
                                <label for="communicatable_id" class="block text-sm font-medium text-gray-300">Select Contact</label>
                                <select id="communicatable_id" name="communicatable_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Contact</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" data-type="App\Models\Customer" {{ old('communicatable_id', $communication->communicatable_id) == $customer->id && old('communicatable_type', $communication->communicatable_type) == 'App\Models\Customer' ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }} (Customer)
                                        </option>
                                    @endforeach
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" data-type="App\Models\Lead" {{ old('communicatable_id', $communication->communicatable_id) == $lead->id && old('communicatable_type', $communication->communicatable_type) == 'App\Models\Lead' ? 'selected' : '' }}>
                                            {{ $lead->first_name }} {{ $lead->last_name }} (Lead)
                                        </option>
                                    @endforeach
                                </select>
                                @error('communicatable_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Scheduled At -->
                            <div>
                                <label for="scheduled_at" class="block text-sm font-medium text-gray-300">Scheduled At</label>
                                <input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('scheduled_at', $communication->scheduled_at ? $communication->scheduled_at->format('Y-m-d\TH:i') : '') }}" required>
                                @error('scheduled_at')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Status</option>
                                    <option value="planned" {{ old('status', $communication->status) == 'planned' ? 'selected' : '' }}>Planned</option>
                                    <option value="completed" {{ old('status', $communication->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $communication->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="md:col-span-2">
                                <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
                                <textarea id="content" name="content" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>{{ old('content', $communication->content) }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-300">Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">{{ old('notes', $communication->notes) }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('communications.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Update Communication
                            </button>
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

                // Reset the selection if the current selection doesn't match the type
                const currentOption = options.find(option => option.value === idSelect.value);
                if (currentOption && currentOption.dataset.type !== selectedType) {
                    idSelect.value = '';
                }
            });

            // Trigger change event on page load if type is already selected
            if (typeSelect.value) {
                typeSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
    @endpush
@endsection
