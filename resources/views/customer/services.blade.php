@extends('layouts.customer')

@section('title', 'My Services')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Services</div>
        <h1 class="headline">My Services</h1>
        <p class="subhead">Manage all your active hosting services and servers.</p>
    </div>
</div>

<div style="margin-top: 48px; background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 40px;">
    <p style="color: var(--muted); font-size: 15px;">No services found. You can order new services from the marketplace.</p>
</div>
@endsection