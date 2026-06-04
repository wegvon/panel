<div class="pm-page">
    <header class="pm-top-row pm-reveal">
        <div>
            <p class="pm-eyebrow">{{ __('navigation.invoices') }}</p>
            <h1 class="pm-headline">{{ __('invoices.invoices') }}</h1>
            <p class="pm-subhead">{{ __('dashboard.unpaid_invoices') }}: {{ $invoices->where('status', 'pending')->count() }}</p>
        </div>
    </header>

    <div class="pm-divider"></div>

    <div class="pm-list pm-reveal" style="animation-delay: 80ms">
        @forelse ($invoices as $invoice)
            <a href="{{ route('invoices.show', $invoice) }}" class="pm-row" wire:navigate>
                <div class="pm-row-icon sand">
                    <x-ri-bill-line class="size-5" />
                </div>
                <div>
                    <p class="pm-row-title">
                        {{ !$invoice->number && config('settings.invoice_proforma', false) ? __('invoices.proforma_invoice', ['id' => $invoice->id]) : __('invoices.invoice', ['id' => $invoice->number]) }}
                    </p>
                    <div class="pm-row-meta">
                        <span><x-ri-wallet-3-line class="size-3" />{{ $invoice->formattedTotal }}</span>
                        <span><x-ri-calendar-line class="size-3" />{{ $invoice->created_at->format('d M Y') }}</span>
                        @if($invoice->items->first())
                            <span><x-ri-file-list-3-line class="size-3" />{{ $invoice->items->first()->description }}</span>
                        @endif
                    </div>
                </div>
                <span class="pm-status {{ $invoice->status === 'paid' ? '' : ($invoice->status === 'pending' ? 'warn' : 'bad') }}">
                    {{ str($invoice->status)->headline() }}
                </span>
            </a>
        @empty
            <div class="pm-empty">{{ __('invoices.no_invoices') }}</div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $invoices->links() }}
    </div>
</div>
