<div class="pm-page">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100%; flex: 1;">
        <div style="width: 100%; max-width: 440px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 40px;">
                <div style="display: inline-flex; align-items: center; gap: 12px;">
                    <svg width="36" height="36" viewBox="0 0 48 48" aria-hidden="true" style="color: #0f1020;">
                        <circle cx="12" cy="14" r="5" fill="currentColor"/>
                        <circle cx="24" cy="9" r="5" fill="currentColor"/>
                        <circle cx="36" cy="14" r="5" fill="currentColor"/>
                        <circle cx="12" cy="30" r="5" fill="currentColor"/>
                        <circle cx="24" cy="25" r="5" fill="currentColor"/>
                        <circle cx="36" cy="30" r="5" fill="currentColor"/>
                        <path d="M16.5 13.2 20 10.8M28 10.8l3.5 2.4M16.5 29.2 20 26.8M28 26.8l3.5 2.4M12 19v6M36 19v6" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                    <span style="font-size: 23px; font-weight: 800; letter-spacing: -0.03em; color: #11111a;">{{ config('app.name', 'ServerHop') }}</span>
                </div>
                <p class="pm-subhead" style="margin-top: 16px;">{{ __('auth.sign_in_title') }}</p>
            </div>

            <form
                class="pm-panel"
                wire:submit="submit" id="login"
                style="padding: 36px 32px;">
                <div style="display: grid; gap: 20px;">
                    <div>
                        <label for="email" style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 750; color: #77757d;">{{ __('general.input.email') }}</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            wire:model="email"
                            required
                            autocomplete="email"
                            placeholder="{{ __('general.input.email_placeholder') }}"
                            style="width: 100%; min-height: 46px; padding: 0 16px; border: 1px solid #e8e5e1; border-radius: 14px; background: #f8f8f7; color: #11111a; font-size: 15px; font-family: inherit; outline: none; transition: border-color 160ms ease; box-sizing: border-box;"
                        >
                        @error('email') <span style="display: block; margin-top: 4px; font-size: 12px; font-weight: 650; color: #f26368;">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password" style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 750; color: #77757d;">{{ __('general.input.password') }}</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            wire:model="password"
                            required
                            autocomplete="current-password"
                            placeholder="{{ __('general.input.password_placeholder') }}"
                            style="width: 100%; min-height: 46px; padding: 0 16px; border: 1px solid #e8e5e1; border-radius: 14px; background: #f8f8f7; color: #11111a; font-size: 15px; font-family: inherit; outline: none; transition: border-color 160ms ease; box-sizing: border-box;"
                        >
                        @error('password') <span style="display: block; margin-top: 4px; font-size: 12px; font-weight: 650; color: #f26368;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 16px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; font-weight: 650; color: #77757d;">
                        <input type="checkbox" wire:model="remember" style="accent-color: #11111a; width: 16px; height: 16px;">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" style="font-size: 13px; font-weight: 650; color: #6ca9cf; text-decoration: none;">
                        {{ __('auth.forgot_password') }}
                    </a>
                </div>

                <x-captcha :form="'login'" />

                <button type="submit" class="pm-button" style="width: 100%; margin-top: 24px;">
                    {{ __('auth.sign_in') }}
                </button>

                {!! hook('auth.login') !!}

                @if (config('settings.oauth_github') || config('settings.oauth_google') || config('settings.oauth_discord'))
                <div style="margin-top: 28px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <span style="flex: 1; height: 1px; background: #e8e5e1;"></span>
                        <span style="font-size: 12px; font-weight: 750; color: #b6b3b0; text-transform: uppercase; letter-spacing: 0.05em;">{{ __('auth.or_sign_in_with') }}</span>
                        <span style="flex: 1; height: 1px; background: #e8e5e1;"></span>
                    </div>
                    <div style="display: flex; justify-content: center; gap: 12px; margin-top: 16px;">
                        @foreach (['github', 'google', 'discord'] as $provider)
                        @if (config('settings.oauth_' . $provider))
                        <a href="{{ route('oauth.redirect', $provider) }}"
                            style="display: inline-flex; align-items: center; gap: 8px; min-height: 42px; padding: 0 16px; border: 1px solid #e8e5e1; border-radius: 999px; background: #fff; color: #11111a; font-size: 14px; font-weight: 700; text-decoration: none;">
                            <img src="/assets/images/{{ $provider }}-dark.svg" alt="{{ $provider }}" style="width: 18px; height: 18px;">
                            {{ __(ucfirst($provider)) }}
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!config('settings.registration_disabled', false))
                <div style="margin-top: 28px; text-align: center; font-size: 14px; font-weight: 600; color: #77757d;">
                    {{ __('auth.dont_have_account') }}
                    <a href="{{ route('register') }}" wire:navigate style="color: #6ca9cf; font-weight: 750; text-decoration: none;">
                        {{ __('auth.sign_up') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
