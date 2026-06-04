@php
    $user = auth()->user();
    $invoices = $user->invoices()->latest()->get();
@endphp

@extends('layouts.customer')

@section('title', __('navigation.invoices'))

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">{{ __('navigation.invoices') }}</div>
        <h1 class="headline">{{ __('invoices.invoices') }}</h1>
        <p class="subhead">{{ __('dashboard.unpaid_invoices') }}: {{ $invoices->where('status', 'pending')->count() }}</p>
    </div>
</div>

<div style="margin-top: 48px; display: grid; gap: 14px;">
    @forelse($invoices as $invoice)
    <a href="{{ route('invoices.show', $invoice) }}" style="display: grid; grid-template-columns: 50px minmax(0, 1fr) auto; align-items: center; gap: 15px; padding: 15px; border: 1px solid rgba(232, 229, 225, 0.88); border-radius: 18px; background: var(--panel); color: var(--ink); text-decoration: none; box-shadow: var(--soft-shadow); transition: transform 160ms ease;">
        <div style="width: 50px; height: 50px; display: grid; place-items: center; border-radius: 50%; background: #faecd8; color: var(--ink); font-size: 17px;">
            <i class="fas fa-file-invoice" style="font-size: 16px;"></i>
        </div>
        <div>
            <p style="margin: 0; font-size: 15px; font-weight: 850; letter-spacing: -0.025em;">
                {{ !$invoice->number && config('settings.invoice_proforma', false) ? __('invoices.proforma_invoice', ['id' => $invoice->id]) : __('invoices.invoice', ['id' => $invoice->number]) }}
            </p>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px; color: var(--muted); font-size: 12px; font-weight: 750;">
                <span><i class="fas fa-wallet" style="font-size: 11px;"></i> {{ $invoice->formattedTotal }}</span>
                <span><i class="fas fa-calendar" style="font-size: 11px;"></i> {{ $invoice->created_at->format('d M Y') }}</span>
            </div>
        </div>
        <span style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; color: var(--ink); font-size: 13px; font-weight: 850;">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ $invoice->status === 'paid' ? 'var(--green)' : ($invoice->status === 'pending' ? 'var(--sand)' : 'var(--red)') }};"></span>
            {{ str($invoice->status)->headline() }}
        </span>
    </a>
    @empty
    <div style="padding: 40px; border: 1px dashed #d8d4cf; border-radius: 20px; background: var(--panel-muted); color: var(--muted); font-size: 15px; font-weight: 650; text-align: center;">
        {{ __('invoices.no_invoices') }}
    </div>
    @endforelse
</div>
@endsection