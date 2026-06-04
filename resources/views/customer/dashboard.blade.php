@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Overview</div>
        <h1 class="headline">Dashboard</h1>
        <p class="subhead">Welcome to your dashboard.</p>
    </div>
</div>
<div style="margin-top: 48px; padding: 40px; border: 1px solid var(--line); border-radius: 20px; background: var(--panel-muted);">
    <p style="color: var(--muted);">Dashboard content loading...</p>
</div>
@endsection
