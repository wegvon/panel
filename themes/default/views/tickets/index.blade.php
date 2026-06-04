<div class="pm-page">
    <header class="pm-top-row pm-reveal">
        <div>
            <p class="pm-eyebrow">{{ __('navigation.tickets') }}</p>
            <h1 class="pm-headline">{{ __('navigation.tickets') }}</h1>
            <p class="pm-subhead">{{ __('dashboard.open_tickets') }}: {{ $tickets->where('status', '!=', 'closed')->count() }}</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="pm-button" wire:navigate>
            <x-ri-add-line class="size-4" />
            {{ __('ticket.create_ticket') }}
        </a>
    </header>

    <div class="pm-divider"></div>

    <div class="pm-list pm-reveal" style="animation-delay: 80ms">
        @forelse ($tickets as $ticket)
            <a href="{{ route('tickets.show', $ticket) }}" class="pm-row" wire:navigate>
                <div class="pm-row-icon gray">
                    <x-ri-ticket-line class="size-5" />
                </div>
                <div>
                    <p class="pm-row-title">#{{ $ticket->id }} - {{ $ticket->subject }}</p>
                    <div class="pm-row-meta">
                        <span>
                            <x-ri-time-line class="size-3" />
                            {{ __('ticket.last_activity') }}
                            {{ $ticket->messages()->latest()->first()?->created_at?->diffForHumans() ?? '-' }}
                        </span>
                        @if($ticket->department)
                            <span><x-ri-inbox-archive-line class="size-3" />{{ $ticket->department }}</span>
                        @endif
                    </div>
                </div>
                <span class="pm-status {{ $ticket->status === 'open' ? '' : ($ticket->status === 'closed' ? 'bad' : 'warn') }}">
                    {{ str($ticket->status)->headline() }}
                </span>
            </a>
        @empty
            <div class="pm-empty">{{ __('ticket.no_tickets') }}</div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
</div>
