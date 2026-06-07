<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(in_array(app()->getLocale(), config('app.rtl_locales'))) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'ServerHop') }}
        @isset($title)
        - {{ $title }}
        @endisset
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @livewireStyles
    @vite(['themes/' . config('settings.theme') . '/js/app.js', 'themes/' . config('settings.theme') . '/css/app.css'], config('settings.theme'))
    @include('layouts.colors')
    @include('layouts.styles')

    @if (config('settings.favicon'))
    <link rel="icon" href="{{ Storage::url(config('settings.favicon')) }}">
    @endif
    @isset($title)
    <meta content="{{ isset($title) ? config('app.name', 'ServerHop') . ' - ' . $title : config('app.name', 'ServerHop') }}" property="og:title">
    <meta content="{{ isset($title) ? config('app.name', 'ServerHop') . ' - ' . $title : config('app.name', 'ServerHop') }}" name="title">
    @endisset
    @isset($description)
    <meta content="{{ $description }}" property="og:description">
    <meta content="{{ $description }}" name="description">
    @endisset
    @isset($image)
    <meta content="{{ $image }}" property="og:image">
    <meta content="{{ $image }}" name="image">
    @endisset

    <meta name="theme-color" content="{{ theme('primary') }}">

    {!! hook('head') !!}
</head>

<body class="w-full text-base min-h-screen flex flex-col antialiased paymenter-body"
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
    :class="{'dark': isDark}"
>
    {!! hook('body') !!}
    @if (isset($sidebar) && $sidebar)
        <div class="paymenter-shell">
            <x-navigation.sidebar title="$title" />
            <main class="paymenter-main">
                {{ $slot }}
            </main>
        </div>
        <x-notification />
        <x-confirmation />
        <x-impersonating />
    @elseif (request()->routeIs('login'))
        {{ $slot }}
    @else
        <x-navigation />
        <div class="w-full flex flex-grow">
            <div class="flex flex-col flex-grow overflow-auto">
                <main class="mt-16 grow">
                    {{ $slot }}
                </main>
                <x-notification />
                <x-confirmation />
                <div class="flex">
                    <x-navigation.footer />
                </div>
            </div>
            <x-impersonating />
        </div>
    @endif
    @livewireScriptConfig
    {!! hook('footer') !!}
</body>

</html>
