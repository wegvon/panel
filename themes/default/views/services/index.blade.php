<div class="pm-page">
    <header class="pm-top-row pm-reveal">
        <div>
            <p class="pm-eyebrow">{{ __('navigation.services') }}</p>
            <h1 class="pm-headline">{{ __('services.services') }}</h1>
            <p class="pm-subhead">{{ __('dashboard.dashboard_description') }}</p>
        </div>
        <a href="{{ route('home') }}" class="pm-button" wire:navigate>
            <x-ri-shopping-bag-4-line class="size-4" />
            {{ __('navigation.shop') }}
        </a>
    </header>

    <div class="pm-divider"></div>

    <div class="pm-list pm-reveal" style="animation-delay: 80ms">
        @forelse ($services as $service)
            <a href="{{ route('services.show', $service) }}" class="pm-row" wire:navigate>
                <div class="pm-row-icon">
                    <x-ri-instance-line class="size-5" />
                </div>
                <div>
                    <p class="pm-row-title">{{ $service->label }}</p>
                    <div class="pm-row-meta">
                        <span><x-ri-price-tag-3-line class="size-3" />{{ $service->formattedPrice }}</span>
                        @if($service->plan->type === 'recurring')
                            <span>
                                <x-ri-loop-right-line class="size-3" />
                                {{ __('services.every_period', [
                                    'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                                    'unit' => trans_choice(__('services.billing_cycles.' . $service->plan->billing_unit), $service->plan->billing_period)
                                ]) }}
                            </span>
                        @endif
                        @if($service->expires_at && $service->expires_at > now())
                            <span><x-ri-calendar-line class="size-3" />{{ __('services.renews_in') }} {{ $service->expires_at->longAbsoluteDiffForHumans() }}</span>
                        @endif
                    </div>
                </div>
                <span class="pm-status {{ $service->status === 'active' ? '' : ($service->status === 'pending' ? 'warn' : 'bad') }}">
                    {{ __('services.statuses.' . $service->status) }}
                </span>
            </a>
        @empty
            <div class="pm-empty">{{ __('services.no_services') }}</div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>
