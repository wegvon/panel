@php
    $user = auth()->user();
    $activeServices = $user->services()->where('status', 'active')->count();
    $pendingInvoices = $user->invoices()->where('status', 'pending')->count();
    $openTickets = $user->tickets()->where('status', '!=', 'closed')->count();
    $latestServices = $user->services()->with(['product', 'plan', 'properties', 'configs.configOption', 'configs.configValue'])->latest()->take(4)->get();
    $featuredService = $latestServices->first();
    $latestInvoice = $user->invoices()->latest()->first();
    $creditsTotal = $user->credits()->sum('amount');
@endphp

<div class="pm-page">
    <header class="pm-top-row pm-reveal">
        <div>
            <p class="pm-eyebrow">{{ __('dashboard.dashboard_title') }}</p>
            <h1 class="pm-headline">{{ __('dashboard.welcome_back', ['name' => $user->first_name ?? $user->name]) }}</h1>
            <p class="pm-subhead">{{ __('dashboard.dashboard_description') }}</p>
        </div>
        <div class="flex items-center gap-4 whitespace-nowrap text-sm font-bold">
            <span>{{ now()->format('d M, Y') }}</span>
            <a href="{{ route('account') }}" class="pm-round-button" wire:navigate aria-label="{{ __('navigation.account') }}">
                <x-ri-user-settings-line class="size-5" />
            </a>
        </div>
    </header>

    <div class="pm-divider"></div>

    <section class="pm-stats pm-reveal" style="animation-delay: 80ms" aria-label="{{ __('dashboard.dashboard_title') }}">
        <article class="pm-stat">
            <div class="pm-stat-icon"><x-ri-archive-stack-line class="size-5" /></div>
            <div>
                <p class="pm-stat-label">{{ __('dashboard.active_services') }}</p>
                <div class="pm-stat-value">{{ $activeServices }} <span class="pm-delta">{{ __('services.statuses.active') }}</span></div>
            </div>
        </article>
        <article class="pm-stat">
            <div class="pm-stat-icon"><x-ri-receipt-line class="size-5" /></div>
            <div>
                <p class="pm-stat-label">{{ __('dashboard.unpaid_invoices') }}</p>
                <div class="pm-stat-value">{{ $pendingInvoices }} <span class="pm-delta{{ $pendingInvoices > 0 ? ' pm-delta-warn' : '' }}">{{ $latestInvoice?->formattedTotal }}</span></div>
            </div>
        </article>
        <article class="pm-stat">
            <div class="pm-stat-icon"><x-ri-customer-service-2-line class="size-5" /></div>
            <div>
                <p class="pm-stat-label">{{ __('dashboard.open_tickets') }}</p>
                <div class="pm-stat-value">{{ $openTickets }} <span class="pm-delta">{{ __('ticket.last_activity') }}</span></div>
            </div>
        </article>
        <article class="pm-stat">
            <div class="pm-stat-icon"><x-ri-wallet-3-line class="size-5" /></div>
            <div>
                <p class="pm-stat-label">{{ __('account.credits') }}</p>
                <div class="pm-stat-value">{{ number_format($creditsTotal, 2) }}</div>
            </div>
        </article>
    </section>

    <section class="pm-workspace pm-reveal" style="animation-delay: 150ms">
        <article class="pm-focus">
            <div>
                <div class="flex items-start justify-between gap-4">
                    <span class="pm-badge">
                        <x-ri-sparkling-line class="size-4" />
                        {{ __('dashboard.active_services') }}
                    </span>
                    @if($featuredService)
                        <a href="{{ route('services.show', $featuredService) }}" class="pm-round-button" wire:navigate aria-label="{{ __('common.button.view') }}">
                            <x-ri-arrow-right-up-line class="size-5" />
                        </a>
                    @endif
                </div>

                @if($featuredService)
                    <h2 class="mt-6 max-w-80 text-3xl font-extrabold leading-tight tracking-[-0.055em]">{{ $featuredService->label }}</h2>
                    <p class="mt-4 max-w-96 text-sm font-semibold leading-6 text-[#716f75]">
                        {{ $featuredService->product->name }} · {{ $featuredService->formattedPrice }}
                    </p>
                    <!-- DEBUG: label={{ $featuredService->getRawOriginal('label') ?? 'NULL' }}, baseLabel={{ $featuredService->baseLabel }}, identifier={{ $featuredService->identifier ?? 'NULL' }} -->
                @else
                    <h2 class="mt-6 max-w-80 text-3xl font-extrabold leading-tight tracking-[-0.055em]">{{ __('services.no_services') }}</h2>
                    <p class="mt-4 max-w-96 text-sm font-semibold leading-6 text-[#716f75]">{{ __('dashboard.dashboard_description') }}</p>
                @endif
            </div>

            <div class="pm-mini-grid">
                <div class="pm-mini-metric">
                    <span>{{ __('services.status') }}</span>
                    <strong>{{ $featuredService ? __('services.statuses.' . $featuredService->status) : '-' }}</strong>
                </div>
                <div class="pm-mini-metric">
                    <span>{{ __('services.renews_on') }}</span>
                    <strong>{{ $featuredService?->expires_at?->format('d M') ?? '-' }}</strong>
                </div>
                <div class="pm-mini-metric">
                    <span>{{ __('services.billing_cycle') }}</span>
                    <strong>{{ $featuredService?->plan?->billing_unit ? trans_choice(__('services.billing_cycles.' . $featuredService->plan->billing_unit), $featuredService->plan->billing_period) : '-' }}</strong>
                </div>
            </div>
        </article>

        <div>
            <div class="pm-section-head mt-0 mb-5">
                <div>
                    <h2 class="pm-section-title">{{ __('navigation.services') }}</h2>
                    <p class="mt-1 text-sm font-semibold text-[#77757d]">{{ __('dashboard.dashboard_description') }}</p>
                </div>
                <a href="{{ route('services') }}" class="pm-button-secondary" wire:navigate>{{ __('dashboard.view_all') }}</a>
            </div>

            <div class="pm-list">
                @forelse($latestServices as $service)
                    <a href="{{ route('services.show', $service) }}" class="pm-row" wire:navigate>
                        <div class="pm-row-icon"><x-ri-instance-line class="size-5" /></div>
                        <div>
                            <p class="pm-row-title">{{ $service->label }}</p>
                            <div class="pm-row-meta">
                                <span><x-ri-shopping-bag-4-line class="size-3" />{{ $service->product->name }}</span>
                                @if($service->expires_at)
                                    <span><x-ri-calendar-line class="size-3" />{{ $service->expires_at->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="pm-status {{ $service->status === 'active' ? '' : 'warn' }}">{{ __('services.statuses.' . $service->status) }}</span>
                    </a>
                @empty
                    <div class="pm-empty">{{ __('services.no_services') }}</div>
                @endforelse
            </div>
        </div>
    </section>

    {!! hook('pages.dashboard') !!}
</div>
