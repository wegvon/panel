@extends('layouts.customer')

@section('title', 'Domains')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Domains</div>
        <h1 class="headline">Domains</h1>
        <p class="subhead">Manage your registered domains and DNS settings.</p>
    </div>
</div>

<div style="margin-top: 48px; background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 40px;">
    <p style="color: var(--muted); font-size: 15px;">No domains registered yet.</p>
</div>
@endsection