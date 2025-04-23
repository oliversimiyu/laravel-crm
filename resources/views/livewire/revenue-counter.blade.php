<div wire:poll.{{ $pollingInterval }}ms="calculateRevenue" class="bg-gray-800 rounded-lg shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-white">Revenue</h2>
        <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center text-white">
            <span class="text-lg">₹</span>
        </div>
    </div>
    <div class="text-3xl font-bold text-white">
        KES {{ number_format($revenue, 2) }}
    </div>
    <div class="text-sm text-gray-400 mt-2">
        Real-time revenue tracking
    </div>
</div>
