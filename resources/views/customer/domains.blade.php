@extends('layouts.customer')

@section('title', 'Domains')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Domains</div>
        <h1 class="headline">Domains</h1>
        <p class="subhead">Manage your registered domains and DNS settings.</p>
    </div>
    <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 9px; padding: 0 18px; min-height: 42px; border-radius: 999px; background: linear-gradient(180deg, #b9def5 0%, #8dc5ea 100%); color: #0f1020; font-size: 14px; font-weight: 800; text-decoration: none; box-shadow: 0 14px 30px rgba(115, 176, 214, 0.26);">
        <i class="fas fa-shopping-bag"></i> {{ __('navigation.shop') }}
    </a>
</div>

<div style="margin-top: 48px; padding: 60px 40px; border: 1px dashed #d8d4cf; border-radius: 20px; background: var(--panel-muted); text-align: center;">
    <i class="fas fa-globe" style="font-size: 48px; color: var(--faint); margin-bottom: 20px; display: block;"></i>
    <p style="color: var(--muted); font-size: 17px; font-weight: 650; margin: 0 0 8px;">No domains registered yet</p>
    <p style="color: var(--faint); font-size: 14px; margin: 0;">Domain management will be available soon.</p>
</div>
@endsection