@php
    $user = auth()->user();
    $activeServices = $user->services()->where('status', 'active')->count();
    $pendingInvoices = $user->invoices()->where('status', 'pending')->count();
    $openTickets = $user->tickets()->where('status', '!=', 'closed')->count();
    $latestServices = $user->services()->with(['product', 'plan'])->latest()->take(5)->get();
    $creditsTotal = $user->credits()->sum('amount');
@endphp

@extends('layouts.customer')

@section('title', __('dashboard.dashboard_title'))

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">{{ __('dashboard.dashboard_title') }}</div>
        <h1 class="headline">{{ __('dashboard.welcome_back', ['name' => $user->first_name ?? $user->name]) }}</h1>
        <p class="subhead">{{ __('dashboard.dashboard_description') }}</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-top: 48px;">
    <div style="background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: var(--muted); letter-spacing: 0.02em;">{{ strtoupper(__('dashboard.active_services')) }}</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">{{ $activeServices }}</div>
    </div>
    <div style="background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: var(--muted); letter-spacing: 0.02em;">{{ strtoupper(__('dashboard.unpaid_invoices')) }}</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">{{ $pendingInvoices }}</div>
    </div>
    <div style="background: linear-gradient(180deg, #11111a 0%, #1a1a24 100%); color: white; border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.6); letter-spacing: 0.02em;">{{ strtoupper(__('account.credits')) }}</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">{{ number_format($creditsTotal, 2) }}</div>
    </div>
    <div style="background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: var(--muted); letter-spacing: 0.02em;">{{ strtoupper(__('dashboard.open_tickets')) }}</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">{{ $openTickets }}</div>
    </div>
</div>

@if($latestServices->isNotEmpty())
<div style="margin-top: 48px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 800; letter-spacing: -0.045em; margin: 0;">{{ __('navigation.services') }}</h2>
        <a href="{{ route('customer.services') }}" style="display: inline-flex; align-items: center; gap: 9px; padding: 0 18px; min-height: 42px; border-radius: 999px; background: #f3f2f1; color: var(--ink); font-size: 14px; font-weight: 750; text-decoration: none;">
            {{ __('dashboard.view_all') }}
        </a>
    </div>

    <div style="display: grid; gap: 14px;">
        @foreach($latestServices as $service)
        <a href="{{ route('services.show', $service) }}" style="display: grid; grid-template-columns: 50px minmax(0, 1fr) auto; align-items: center; gap: 15px; padding: 15px; border: 1px solid rgba(232, 229, 225, 0.88); border-radius: 18px; background: var(--panel); color: var(--ink); text-decoration: none; box-shadow: var(--soft-shadow); transition: transform 160ms ease;">
            <div style="width: 50px; height: 50px; display: grid; place-items: center; border-radius: 50%; background: #eef4fb; color: var(--ink); font-size: 17px;">
                <i class="fas fa-server" style="font-size: 16px;"></i>
            </div>
            <div>
                <p style="margin: 0; font-size: 15px; font-weight: 850; letter-spacing: -0.025em;">{{ $service->label }}</p>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px; color: var(--muted); font-size: 12px; font-weight: 750;">
                    <span><i class="fas fa-tag" style="font-size: 11px;"></i> {{ $service->product->name }}</span>
                    @if($service->expires_at)
                    <span><i class="fas fa-calendar" style="font-size: 11px;"></i> {{ $service->expires_at->format('d M Y') }}</span>
                    @endif
                </div>
            </div>
            <span style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; color: var(--ink); font-size: 13px; font-weight: 850;">
                <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ $service->status === 'active' ? 'var(--green)' : 'var(--sand)' }};"></span>
                {{ __('services.statuses.' . $service->status) }}

            </span>
        </a>
        @endforeach
    </div>
</div>
@endif
@endsection
