@php
    $user = auth()->user();
    $credits = $user->credits()->latest()->take(20)->get();
    $creditsTotal = $user->credits()->sum('amount');
@endphp

@extends('layouts.customer')

@section('title', __('account.payment-methods'))

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">{{ __('account.credits') }}</div>
        <h1 class="headline">{{ __('account.payment-methods') }}</h1>
        <p class="subhead">{{ __('account.credits') }}: {{ number_format($creditsTotal, 2) }}</p>
    </div>
    <a href="{{ route('account') }}" style="display: inline-flex; align-items: center; gap: 9px; padding: 0 18px; min-height: 42px; border-radius: 999px; background: #f3f2f1; color: var(--ink); font-size: 14px; font-weight: 750; text-decoration: none;">
        <i class="fas fa-cog"></i> {{ __('navigation.account') }}
    </a>
</div>

@if($credits->isNotEmpty())
<div style="margin-top: 48px;">
    <h2 style="font-size: 20px; font-weight: 800; margin: 0 0 18px;">{{ __('account.credits') }}</h2>
    <div style="display: grid; gap: 10px;">
        @foreach($credits as $credit)
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border: 1px solid var(--line); border-radius: 16px; background: var(--panel); box-shadow: var(--soft-shadow);">
            <div>
                <p style="margin: 0; font-size: 15px; font-weight: 750;">{{ $credit->description ?? __('account.credits') }}</p>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 13px;">{{ $credit->created_at->format('d M Y, H:i') }}</p>
            </div>
            <span style="font-size: 18px; font-weight: 800; color: {{ $credit->amount >= 0 ? 'var(--green)' : 'var(--red)' }};">
                {{ $credit->amount >= 0 ? '+' : '' }}{{ number_format($credit->amount, 2) }}
            </span>
        </div>
        @endforeach
    </div>
</div>
@endif

<div style="margin-top: 48px; padding: 40px; border: 1px solid var(--line); border-radius: 20px; background: var(--panel-muted); text-align: center;">
    <p style="color: var(--muted); font-size: 15px;">{{ __('navigation.account') }}: {{ __('account.payment-methods') }}</p>
    <a href="{{ route('account.payment-methods') }}" style="display: inline-flex; align-items: center; gap: 9px; margin-top: 16px; padding: 0 18px; min-height: 42px; border-radius: 999px; background: linear-gradient(180deg, #b9def5 0%, #8dc5ea 100%); color: #0f1020; font-size: 14px; font-weight: 800; text-decoration: none;">
        {{ __('common.button.view') }}
    </a>
</div>
@endsection