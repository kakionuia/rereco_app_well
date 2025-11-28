<div {{ $attributes->merge(['class' => 'flex items-center justify-center min-h-[220px] p-6']) }} role="status" aria-live="polite">
    <div class="flex flex-col items-center gap-4">
        <svg class="animate-spin h-16 w-16 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <div class="text-gray-700 font-semibold text-lg">{{ $slot ?? 'Memuat...' }}</div>
        @if(isset($sub))
            <div class="text-sm text-gray-500">{{ $sub }}</div>
        @endif
    </div>
</div>
