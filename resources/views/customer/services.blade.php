@php
    $user = auth()->user();
    $services = $user->services()->with(['product', 'plan'])->latest()->get();
@endphp

@extends('layouts.customer')

@section('title', __('navigation.services'))

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">{{ __('navigation.services') }}</div>
        <h1 class="headline">{{ __('services.services') }}</h1>
        <p class="subhead">{{ __('dashboard.dashboard_description') }}</p>
    </div>
</div>

<div style="margin-top: 48px; display: grid; gap: 14px;">
    @forelse($services as $service)
    <a href="{{ route('services.show', $service) }}" style="display: grid; grid-template-columns: 50px minmax(0, 1fr) auto; align-items: center; gap: 15px; padding: 15px; border: 1px solid rgba(232, 229, 225, 0.88); border-radius: 18px; background: var(--panel); color: var(--ink); text-decoration: none; box-shadow: var(--soft-shadow); transition: transform 160ms ease;">
        <div style="width: 50px; height: 50px; display: grid; place-items: center; border-radius: 50%; background: #eef4fb; color: var(--ink); font-size: 17px;">
            <i class="fas fa-server" style="font-size: 16px;"></i>
        </div>
        <div>
            <p style="margin: 0; font-size: 15px; font-weight: 850; letter-spacing: -0.025em;">{{ $service->label }}</p>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px; color: var(--muted); font-size: 12px; font-weight: 750;">
                <span><i class="fas fa-tag" style="font-size: 11px;"></i> {{ $service->formattedPrice }}</span>
                @if($service->plan->type === 'recurring')
                <span><i class="fas fa-sync-alt" style="font-size: 11px;"></i> {{ $service->plan->billing_period > 1 ? $service->plan->billing_period : '' }} {{ trans_choice(__('services.billing_cycles.' . $service->plan->billing_unit), $service->plan->billing_period) }}</span>
                @endif
                @if($service->expires_at && $service->expires_at > now())
                <span><i class="fas fa-calendar" style="font-size: 11px;"></i> {{ __('services.renews_in') }} {{ $service->expires_at->longAbsoluteDiffForHumans() }}</span>
                @endif
            </div>
        </div>
        <span style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; color: var(--ink); font-size: 13px; font-weight: 850;">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ $service->status === 'active' ? 'var(--green)' : ($service->status === 'pending' ? 'var(--sand)' : 'var(--red)') }};"></span>
            {{ __('services.statuses.' . $service->status) }}
        </span>
    </a>
    @empty
    <div style="padding: 40px; border: 1px dashed #d8d4cf; border-radius: 20px; background: var(--panel-muted); color: var(--muted); font-size: 15px; font-weight: 650; text-align: center;">
        {{ __('services.no_services') }}
    </div>
    @endforelse
</div>
@endsection