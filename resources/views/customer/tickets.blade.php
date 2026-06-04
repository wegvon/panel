@extends('layouts.customer')

@section('title', 'Support Tickets')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Support</div>
        <h1 class="headline">Support Tickets</h1>
        <p class="subhead">Create and manage support requests.</p>
    </div>
</div>

<div style="margin-top: 48px; background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 40px;">
    <p style="color: var(--muted); font-size: 15px;">You have no open tickets.</p>
</div>
@endsection