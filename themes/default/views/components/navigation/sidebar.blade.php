<aside id="main-aside" class="paymenter-sidebar">
    <a href="{{ route('dashboard') }}" class="pm-brand" wire:navigate aria-label="{{ config('app.name') }}">
        <svg class="pm-brand-mark" viewBox="0 0 48 48" aria-hidden="true">
            <circle cx="12" cy="14" r="5" fill="currentColor"/>
            <circle cx="24" cy="9" r="5" fill="currentColor"/>
            <circle cx="36" cy="14" r="5" fill="currentColor"/>
            <circle cx="12" cy="30" r="5" fill="currentColor"/>
            <circle cx="24" cy="25" r="5" fill="currentColor"/>
            <circle cx="36" cy="30" r="5" fill="currentColor"/>
            <path d="M16.5 13.2 20 10.8M28 10.8l3.5 2.4M16.5 29.2 20 26.8M28 26.8l3.5 2.4M12 19v6M36 19v6" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
        </svg>
        <span class="pm-brand-name">{{ config('app.name') }}</span>
    </a>

    <x-navigation.sidebar-links />

    <section class="pm-upgrade-card">
        <h3>{{ __('navigation.tickets') }}</h3>
        <p>{{ __('ticket.create_ticket') }}</p>
        <a href="{{ route('tickets.create') }}" class="pm-button" wire:navigate>{{ __('common.button.view') }}</a>
    </section>

    <ul class="pm-utility-list">
        <li>
            <a class="pm-utility-link" href="{{ route('account') }}" wire:navigate>
                <x-ri-settings-3-line class="pm-utility-icon" />
                <span>{{ __('navigation.account') }}</span>
            </a>
        </li>
        <li>
            <livewire:auth.logout />
        </li>
    </ul>
</aside>
