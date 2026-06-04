@extends('layouts.customer')

@section('title', 'Invoices')

@section('content')
<div class="top-row">
    <div>
        <div class="eyebrow">Billing</div>
        <h1 class="headline">Invoices</h1>
        <p class="subhead">View and download all your invoices.</p>
    </div>
</div>

<div style="margin-top: 48px; background: var(--panel); border: 1px solid var(--line); border-radius: 20px; padding: 40px;">
    <p style="color: var(--muted); font-size: 15px;">No invoices yet.</p>
</div>
@endsection