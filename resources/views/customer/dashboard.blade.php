<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(in_array(app()->getLocale(), config('app.rtl_locales'))) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ServerHop') }} - {{ __('dashboard.dashboard_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @livewireStyles
    @vite(['themes/' . config('settings.theme') . '/js/app.js', 'themes/' . config('settings.theme') . '/css/app.css'], config('settings.theme'))
    @include('layouts.colors')
    @include('layouts.styles')
</head>

<body class="w-full bg-background text-base min-h-screen flex flex-col antialiased paymenter-body"
    x-cloak
    x-data="{
        theme: $persist('system').as('theme_mode'),
        systemDark: window.matchMedia('(prefers-color-scheme: dark)').matches,
        init() {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                this.systemDark = e.matches;
            });
        },
        get isDark() {
            return this.theme === 'dark' || (this.theme === 'system' && this.systemDark);
        }
    }"
    :class="{'dark': isDark}">
    <div class="paymenter-shell">
        <x-navigation.sidebar title="dashboard" />
        <main class="paymenter-main">
            <livewire:dashboard />
        </main>
    </div>
    <x-notification />
    <x-confirmation />
    <x-impersonating />
    @livewireScriptConfig
</body>

</html>
