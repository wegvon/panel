<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'ServerHop') }} - {{ __('auth.forgot_password') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  @livewireStyles
  @vite(['themes/' . config('settings.theme') . '/js/app.js', 'themes/' . config('settings.theme') . '/css/app.css'], config('settings.theme'))
  @include('layouts.colors')
  <style>
    :root {
      --page: #d8d6d6;
      --panel: #ffffff;
      --panel-muted: #f4f4f3;
      --ink: #11111a;
      --muted: #77757d;
      --faint: #b6b3b0;
      --line: #e8e5e1;
      --blue: #99ccee;
      --blue-strong: #6ca9cf;
      --sand: #e8b877;
      --green: #56b89d;
      --red: #f26368;
      --shadow: 0 40px 90px rgba(35, 31, 29, 0.18);
      --soft-shadow: 0 18px 45px rgba(27, 26, 24, 0.08);
    }

    * { box-sizing: border-box; }

    body {
      min-height: 100svh;
      margin: 0;
      display: grid;
      place-items: center;
      padding: 34px;
      background: radial-gradient(circle at 50% 100%, rgba(255,255,255,0.42), transparent 34rem), var(--page);
      color: var(--ink);
      font-family: "Manrope", system-ui, sans-serif;
      letter-spacing: 0;
      -webkit-font-smoothing: antialiased;
    }

    button, input { font: inherit; }
    button { cursor: pointer; }

    .auth-shell {
      width: min(460px, 100%);
      padding: 56px 48px;
      border: 1px solid rgba(255, 255, 255, 0.72);
      border-radius: 28px;
      background: var(--panel);
      box-shadow: var(--shadow);
      animation: fadeUp 680ms cubic-bezier(.22,1,.36,1) both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(14px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .brand { display: flex; align-items: center; gap: 13px; margin-bottom: 48px; justify-content: center; }
    .brand-mark { width: 40px; height: 40px; color: #0f1020; }
    .brand-name { font-size: 26px; font-weight: 800; letter-spacing: -0.03em; }

    .auth-head { text-align: center; margin-bottom: 40px; }
    .auth-eyebrow { margin: 0 0 10px; color: #9d9a98; font-size: 12px; font-weight: 800; letter-spacing: 0.18em; text-transform: uppercase; }
    .auth-headline { margin: 0 0 10px; font-size: 32px; line-height: 1.15; font-weight: 800; letter-spacing: -0.055em; }
    .auth-subhead { margin: 0; color: #77757d; font-size: 15px; font-weight: 600; line-height: 1.6; }

    .form-group { margin-bottom: 22px; }
    .form-label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: var(--ink); }
    .input-wrapper { position: relative; }
    .form-input {
      width: 100%; height: 52px; padding: 0 18px;
      border: 1px solid var(--line); border-radius: 14px;
      background: var(--panel); color: var(--ink); font-size: 15px; font-weight: 500;
      transition: border-color 160ms ease, box-shadow 160ms ease, background 160ms ease;
    }
    .form-input::placeholder { color: var(--faint); font-weight: 400; }
    .form-input:hover { border-color: #ddd8d2; }
    .form-input:focus { outline: none; border-color: var(--blue-strong); box-shadow: 0 0 0 4px rgba(153, 204, 238, 0.25); }
    .form-input.error { border-color: var(--red); }
    .form-input.error:focus { box-shadow: 0 0 0 4px rgba(242, 99, 104, 0.18); }
    .input-icon { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 16px; pointer-events: none; }
    .form-input:focus + .input-icon { color: var(--blue-strong); }

    .form-hint { display: flex; align-items: center; justify-content: space-between; margin-top: 8px; font-size: 12px; font-weight: 600; color: var(--muted); }
    .form-hint a { color: var(--blue-strong); text-decoration: none; font-weight: 700; transition: color 160ms ease; }
    .form-hint a:hover { color: var(--ink); text-decoration: underline; }

    .error-message {
      display: flex; align-items: center; gap: 6px;
      margin-top: 8px; padding: 10px 14px;
      border-radius: 10px; background: rgba(242, 99, 104, 0.1);
      color: var(--red); font-size: 13px; font-weight: 600;
    }

    .submit-btn {
      width: 100%; height: 52px; margin-top: 8px;
      border: 0; border-radius: 999px;
      background: linear-gradient(180deg, #b9def5 0%, #8dc5ea 100%);
      color: #0f1020; font-size: 16px; font-weight: 800;
      box-shadow: 0 14px 30px rgba(115, 176, 214, 0.32);
      transition: transform 180ms ease, box-shadow 180ms ease;
    }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 18px 34px rgba(115, 176, 214, 0.42); }
    .submit-btn:active { transform: translateY(0); }
    .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .success-state { display: none; text-align: center; padding: 24px 0; }
    .success-state.visible { display: block; }
    .success-icon {
      width: 80px; height: 80px; margin: 0 auto 24px;
      border-radius: 50%; background: linear-gradient(180deg, #d4f5e1 0%, #a8e8c8 100%);
      display: grid; place-items: center; color: var(--green); font-size: 36px;
      box-shadow: 0 18px 40px rgba(86, 184, 157, 0.25);
    }
    .success-title { margin: 0 0 10px; font-size: 26px; font-weight: 800; letter-spacing: -0.04em; }
    .success-text { margin: 0 0 28px; color: var(--muted); font-size: 15px; font-weight: 600; line-height: 1.6; }

    .secondary-btn {
      width: 100%; height: 52px; border: 1px solid var(--line);
      border-radius: 999px; background: var(--panel); color: var(--ink);
      font-size: 15px; font-weight: 700;
      transition: transform 160ms ease, border-color 160ms ease, background 160ms ease, box-shadow 160ms ease;
    }
    .secondary-btn:hover { transform: translateY(-1px); border-color: #ddd8d2; background: #fafafa; box-shadow: 0 10px 24px rgba(24,22,20,0.06); }

    .auth-foot { margin-top: 32px; text-align: center; color: var(--muted); font-size: 14px; font-weight: 600; }
    .auth-foot a { color: var(--blue-strong); font-weight: 800; text-decoration: none; transition: color 160ms ease; }
    .auth-foot a:hover { color: var(--ink); text-decoration: underline; }

    @media (max-width: 520px) {
      body { padding: 0; place-items: stretch; background: var(--panel); }
      .auth-shell { width: 100%; min-height: 100svh; border-radius: 0; border: none; box-shadow: none; padding: 40px 24px 32px; }
      .brand { margin-bottom: 36px; }
      .brand-mark { width: 36px; height: 36px; }
      .brand-name { font-size: 22px; }
      .auth-headline { font-size: 28px; }
    }
  </style>
</head>
<body>
  <div>
    <main class="auth-shell" role="main">
      <div class="brand" aria-label="{{ config('app.name', 'ServerHop') }}">
        <svg class="brand-mark" viewBox="0 0 48 48" aria-hidden="true">
          <circle cx="12" cy="14" r="5" fill="currentColor"/>
          <circle cx="24" cy="9" r="5" fill="currentColor"/>
          <circle cx="36" cy="14" r="5" fill="currentColor"/>
          <circle cx="12" cy="30" r="5" fill="currentColor"/>
          <circle cx="24" cy="25" r="5" fill="currentColor"/>
          <circle cx="36" cy="30" r="5" fill="currentColor"/>
          <path d="M16.5 13.2 20 10.8M28 10.8l3.5 2.4M16.5 29.2 20 26.8M28 26.8l3.5 2.4M12 19v6M36 19v6" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
        </svg>
        <span class="brand-name">{{ config('app.name', 'ServerHop') }}</span>
      </div>

      <header class="auth-head">
        <p class="auth-eyebrow">Client Console</p>
        <h1 class="auth-headline">{{ __('auth.forgot_password') }}</h1>
        <p class="auth-subhead">Enter your email and we'll send you a reset link</p>
      </header>

      <form wire:submit="submit" id="forgotForm" novalidate>
        <div class="form-group">
          <label class="form-label" for="email">{{ __('general.input.email') }}</label>
          <div class="input-wrapper">
            <input class="form-input {{ $errors->has('email') ? 'error' : '' }}" type="email" id="email" wire:model="email" autocomplete="email" placeholder="{{ __('general.input.email_placeholder') }}" required>
            <i class="input-icon fa-regular fa-envelope" aria-hidden="true"></i>
          </div>
          <div class="form-hint"><span>We'll send reset instructions to this email</span></div>
          @error('email')<div class="error-message" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ $message }}</span></div>@enderror
        </div>

        <x-captcha :form="'password.request'" />

        <button type="submit" class="submit-btn">Send reset link</button>
      </form>

      <p class="auth-foot">
        {{ __('auth.remember_password', default: 'Remember your password?') }} <a href="{{ route('login') }}" wire:navigate>{{ __('auth.sign_in') }}</a>
      </p>
    </main>
  </div>
  @livewireScriptConfig
</body>
</html>
