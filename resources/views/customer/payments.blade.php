@extends('layouts.customer')

@section('title', 'Payments')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Billing</div>
        <h1 class="headline">Payments</h1>
        <p class="subhead">Track all payment transactions.</p>
    </div>
</div>

<div style="margin-top: 48px; background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 40px;">
    <p style="color: var(--muted); font-size: 15px;">No payments recorded.</p>
</div>
@endsection