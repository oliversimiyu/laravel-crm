@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Edit Lead</h1>
                <a href="{{ route('leads.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Back to Leads
                </a>
            </div>

            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 text-gray-100">
                    <form method="POST" action="{{ route('leads.update', $lead) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-300">First Name</label>
                                <input id="first_name" name="first_name" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('first_name', $lead->first_name) }}" required autofocus>
                                @error('first_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-300">Last Name</label>
                                <input id="last_name" name="last_name" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('last_name', $lead->last_name) }}" required>
                                @error('last_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                                <input id="email" name="email" type="email" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('email', $lead->email) }}" required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300">Phone</label>
                                <input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('phone', $lead->phone) }}">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-300">Position</label>
                                <input id="position" name="position" type="text" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('position', $lead->position) }}" required>
                                @error('position')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company -->
                            <div>
                                <label for="company_id" class="block text-sm font-medium text-gray-300">Company</label>
                                <select id="company_id" name="company_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $lead->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Source -->
                            <div>
                                <label for="source" class="block text-sm font-medium text-gray-300">Source</label>
                                <select id="source" name="source" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Source</option>
                                    <option value="website" {{ old('source', $lead->source) == 'website' ? 'selected' : '' }}>Website</option>
                                    <option value="referral" {{ old('source', $lead->source) == 'referral' ? 'selected' : '' }}>Referral</option>
                                    <option value="social_media" {{ old('source', $lead->source) == 'social_media' ? 'selected' : '' }}>Social Media</option>
                                    <option value="email_campaign" {{ old('source', $lead->source) == 'email_campaign' ? 'selected' : '' }}>Email Campaign</option>
                                    <option value="cold_call" {{ old('source', $lead->source) == 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                                    <option value="event" {{ old('source', $lead->source) == 'event' ? 'selected' : '' }}>Event</option>
                                    <option value="other" {{ old('source', $lead->source) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('source')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Value -->
                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-300">Value (KES)</label>
                                <input id="value" name="value" type="number" step="0.01" min="0" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" value="{{ old('value', $lead->value) }}" required>
                                @error('value')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                                    <option value="">Select Status</option>
                                    <option value="new" {{ old('status', $lead->status) == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="contacted" {{ old('status', $lead->status) == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="qualified" {{ old('status', $lead->status) == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                    <option value="proposal" {{ old('status', $lead->status) == 'proposal' ? 'selected' : '' }}>Proposal</option>
                                    <option value="negotiation" {{ old('status', $lead->status) == 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                                    <option value="closed_won" {{ old('status', $lead->status) == 'closed_won' ? 'selected' : '' }}>Closed Won</option>
                                    <option value="closed_lost" {{ old('status', $lead->status) == 'closed_lost' ? 'selected' : '' }}>Closed Lost</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-300">Notes</label>
                            <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">{{ old('notes', $lead->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('leads.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Update Lead
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
