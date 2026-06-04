@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Overview</div>
        <h1 class="headline">Good morning, Türel</h1>
        <p class="subhead">Here's what's happening with your account today.</p>
    </div>
    <div class="date-control">
        <span>Last 30 days</span>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-top: 48px;">
    <div style="background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: var(--muted); letter-spacing: 0.02em;">ACTIVE SERVICES</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">14</div>
    </div>
    <div style="background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: var(--muted); letter-spacing: 0.02em;">MONTHLY SPEND</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">₺2,940</div>
    </div>
    <div style="background: linear-gradient(180deg, #11111a 0%, #1a1a24 100%); color: white; border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.6); letter-spacing: 0.02em;">BALANCE</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">₺12,480</div>
    </div>
    <div style="background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 32px 28px; box-shadow: var(--soft-shadow);">
        <div style="font-size: 13px; font-weight: 700; color: var(--muted); letter-spacing: 0.02em;">OPEN TICKETS</div>
        <div style="font-size: 42px; font-weight: 800; margin-top: 12px; letter-spacing: -0.04em;">2</div>
    </div>
</div>
@endsection