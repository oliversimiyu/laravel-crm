<section>
    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
        @csrf
        @method('delete')

        <div class="bg-red-900/20 border border-red-800/30 rounded p-3 mb-4">
            <p class="text-red-300 text-sm">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" class="form-input" placeholder="{{ __('Enter your password to confirm') }}" />
            @error('password', 'userDeletion')
                <div class="input-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center mt-6">
            <button type="submit" class="action-button danger">{{ __('Delete Account') }}</button>
        </div>
    </form>
</section>
