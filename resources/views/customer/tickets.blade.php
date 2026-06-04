@php
    $user = auth()->user();
    $tickets = $user->tickets()->latest()->get();
@endphp

@extends('layouts.customer')

@section('title', __('ticket.tickets'))

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">{{ __('navigation.tickets') }}</div>
        <h1 class="headline">{{ __('ticket.tickets') }}</h1>
        <p class="subhead">{{ __('ticket.create_ticket') }}</p>
    </div>
    <a href="{{ route('tickets.create') }}" style="display: inline-flex; align-items: center; gap: 9px; padding: 0 18px; min-height: 42px; border-radius: 999px; background: linear-gradient(180deg, #b9def5 0%, #8dc5ea 100%); color: #0f1020; font-size: 14px; font-weight: 800; text-decoration: none; box-shadow: 0 14px 30px rgba(115, 176, 214, 0.26);">
        <i class="fas fa-plus"></i> {{ __('ticket.create_ticket') }}
    </a>
</div>

<div style="margin-top: 48px; display: grid; gap: 14px;">
    @forelse($tickets as $ticket)
    <a href="{{ route('tickets.show', $ticket) }}" style="display: grid; grid-template-columns: 50px minmax(0, 1fr) auto; align-items: center; gap: 15px; padding: 15px; border: 1px solid rgba(232, 229, 225, 0.88); border-radius: 18px; background: var(--panel); color: var(--ink); text-decoration: none; box-shadow: var(--soft-shadow); transition: transform 160ms ease;">
        <div style="width: 50px; height: 50px; display: grid; place-items: center; border-radius: 50%; background: #f0f0ef; color: var(--ink); font-size: 17px;">
            <i class="fas fa-headset" style="font-size: 16px;"></i>
        </div>
        <div>
            <p style="margin: 0; font-size: 15px; font-weight: 850; letter-spacing: -0.025em;">{{ $ticket->subject }}</p>
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px; color: var(--muted); font-size: 12px; font-weight: 750;">
                <span><i class="fas fa-folder" style="font-size: 11px;"></i> {{ $ticket->department?->name ?? '-' }}</span>
                <span><i class="fas fa-calendar" style="font-size: 11px;"></i> {{ $ticket->created_at->format('d M Y') }}</span>
            </div>
        </div>
        <span style="display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; color: var(--ink); font-size: 13px; font-weight: 850;">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ $ticket->status === 'open' ? 'var(--green)' : ($ticket->status === 'waiting' ? 'var(--sand)' : 'var(--muted)') }};"></span>
            {{ str($ticket->status)->headline() }}
        </span>
    </a>
    @empty
    <div style="padding: 40px; border: 1px dashed #d8d4cf; border-radius: 20px; background: var(--panel-muted); color: var(--muted); font-size: 15px; font-weight: 650; text-align: center;">
        {{ __('ticket.no_tickets') }}
    </div>
    @endforelse
</div>
@endsection