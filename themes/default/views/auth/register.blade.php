<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'ServerHop') }} - {{ __('auth.sign_up') }}</title>
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

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 20px; }
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

    .error-message {
      display: flex; align-items: center; gap: 6px;
      margin-top: 8px; padding: 10px 14px;
      border-radius: 10px; background: rgba(242, 99, 104, 0.1);
      color: var(--red); font-size: 13px; font-weight: 600;
    }

    .checkbox-group { display: flex; align-items: flex-start; gap: 10px; margin: 4px 0 28px; }
    .checkbox-input { width: 20px; height: 20px; margin-top: 2px; flex-shrink: 0; accent-color: var(--blue-strong); cursor: pointer; }
    .checkbox-label { font-size: 13px; font-weight: 500; color: var(--muted); line-height: 1.5; }

    .submit-btn {
      width: 100%; height: 52px; margin-top: 4px;
      border: 0; border-radius: 999px;
      background: linear-gradient(180deg, #b9def5 0%, #8dc5ea 100%);
      color: #0f1020; font-size: 16px; font-weight: 800;
      box-shadow: 0 14px 30px rgba(115, 176, 214, 0.32);
      transition: transform 180ms ease, box-shadow 180ms ease;
    }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 18px 34px rgba(115, 176, 214, 0.42); }
    .submit-btn:active { transform: translateY(0); }
    .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .divider-row { display: flex; align-items: center; gap: 16px; margin: 28px 0; }
    .divider-row::before, .divider-row::after { content: ""; flex: 1; height: 1px; background: var(--line); }
    .divider-text { color: var(--muted); font-size: 12px; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; }

    .social-btns { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .social-btn {
      display: inline-flex; align-items: center; justify-content: center; gap: 10px;
      height: 48px; border: 1px solid var(--line); border-radius: 14px;
      background: var(--panel); color: var(--ink); font-size: 14px; font-weight: 700; text-decoration: none;
      transition: transform 160ms ease, border-color 160ms ease, background 160ms ease, box-shadow 160ms ease;
    }
    .social-btn:hover { transform: translateY(-1px); border-color: #ddd8d2; background: #fafafa; box-shadow: 0 10px 24px rgba(24,22,20,0.06); }
    .social-btn svg { width: 20px; height: 20px; }

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
      .form-row { grid-template-columns: 1fr; }
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
        <h1 class="auth-headline">Create your account</h1>
        <p class="auth-subhead">Start managing your infrastructure in minutes</p>
      </header>

      <form wire:submit.prevent="submit" id="registerForm" novalidate>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="first_name">{{ __('general.input.first_name') }}</label>
            <div class="input-wrapper">
              <input class="form-input {{ $errors->has('first_name') ? 'error' : '' }}" type="text" id="first_name" wire:model="first_name" autocomplete="given-name" placeholder="John" required>
              <i class="input-icon fa-regular fa-user" aria-hidden="true"></i>
            </div>
            @error('first_name')<div class="error-message" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ $message }}</span></div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label" for="last_name">{{ __('general.input.last_name') }}</label>
            <div class="input-wrapper">
              <input class="form-input {{ $errors->has('last_name') ? 'error' : '' }}" type="text" id="last_name" wire:model="last_name" autocomplete="family-name" placeholder="Doe" required>
              <i class="input-icon fa-regular fa-user" aria-hidden="true"></i>
            </div>
            @error('last_name')<div class="error-message" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ $message }}</span></div>@enderror
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">{{ __('general.input.email') }}</label>
          <div class="input-wrapper">
            <input class="form-input {{ $errors->has('email') ? 'error' : '' }}" type="email" id="email" wire:model="email" autocomplete="email" placeholder="{{ __('general.input.email_placeholder') }}" required>
            <i class="input-icon fa-regular fa-envelope" aria-hidden="true"></i>
          </div>
          @error('email')<div class="error-message" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ $message }}</span></div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="password">{{ __('general.input.password') }}</label>
          <div class="input-wrapper">
            <input class="form-input {{ $errors->has('password') ? 'error' : '' }}" type="password" id="password" wire:model="password" autocomplete="new-password" placeholder="••••••••" required>
            <i class="input-icon fa-regular fa-lock" aria-hidden="true"></i>
          </div>
          @error('password')<div class="error-message" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ $message }}</span></div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="password_confirmation">{{ __('general.input.confirm_password') }}</label>
          <div class="input-wrapper">
            <input class="form-input {{ $errors->has('password_confirmation') ? 'error' : '' }}" type="password" id="password_confirmation" wire:model="password_confirmation" autocomplete="new-password" placeholder="••••••••" required>
            <i class="input-icon fa-regular fa-lock" aria-hidden="true"></i>
          </div>
          @error('password_confirmation')<div class="error-message" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ $message }}</span></div>@enderror
        </div>

        <div class="checkbox-group">
          <input type="checkbox" class="checkbox-input" id="tos" wire:model="tos" required>
          <label class="checkbox-label" for="tos">{{ __('auth.agree_terms', default: 'I agree to the Terms of Service and Privacy Policy') }}</label>
        </div>
        @error('tos')<div class="error-message" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ $message }}</span></div>@enderror

        <x-captcha :form="'register'" />

        <button type="submit" class="submit-btn">{{ __('auth.create_account', default: 'Create account') }}</button>
      </form>

      @if (config('settings.oauth_github') || config('settings.oauth_google') || config('settings.oauth_discord'))
      <div class="divider-row"><span class="divider-text">{{ __('auth.or_sign_up_with', default: 'or sign up with') }}</span></div>
      <div class="social-btns">
        @foreach (['google', 'github'] as $provider)
        @if (config('settings.oauth_' . $provider))
        <a href="{{ route('oauth.redirect', $provider) }}" class="social-btn">
          @if($provider === 'google')
          <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
          @else
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
          @endif
          <span>{{ ucfirst($provider) }}</span>
        </a>
        @endif
        @endforeach
      </div>
      @endif

      <p class="auth-foot">
        {{ __('auth.already_have_account', default: 'Already have an account?') }} <a href="{{ route('login') }}" wire:navigate>{{ __('auth.sign_in') }}</a>
      </p>
    </main>
  </div>
  @livewireScriptConfig
</body>
</html>
