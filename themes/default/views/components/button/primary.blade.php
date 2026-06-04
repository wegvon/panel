<button 
    {{ $attributes->merge(['class' => 'flex items-center gap-2 justify-center bg-[#99ccee] text-[#0f1020] text-sm font-extrabold hover:bg-[#8dc5ea] py-2.5 lg:py-2 px-5 rounded-full w-full duration-300 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 shadow-[0_14px_30px_rgba(115,176,214,0.24)]']) }}>
    @if (isset($type) && $type === 'submit')
        <div role="status" wire:loading>
            <x-ri-loader-5-fill aria-hidden="true" class="size-6 me-2 fill-background animate-spin" />
            <span class="sr-only">Loading...</span>
        </div>
        <div wire:loading.remove>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</button>
