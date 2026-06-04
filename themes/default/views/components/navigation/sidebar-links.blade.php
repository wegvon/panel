@php
    $dashboardLinks = \App\Classes\Navigation::getDashboardLinks();
    $topLinks = \App\Classes\Navigation::getLinks();
@endphp

<nav aria-label="{{ __('navigation.dashboard') }}">
    <ul class="pm-nav-list">
        @foreach ($dashboardLinks as $nav)
            @if (!empty($nav['children']))
                <li>
                    <details class="pm-nav-group" @if($nav['active']) open @endif>
                        <summary class="pm-nav-link {{ $nav['active'] ? 'active' : '' }}">
                            @isset($nav['icon'])
                                <x-dynamic-component :component="$nav['icon']" class="pm-nav-icon" />
                            @endisset
                            <span class="pm-nav-text">{{ $nav['name'] }}</span>
                            <svg class="pm-nav-chevron" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.00015 18.9999L15.8286 12.1715C16.4066 11.5935 16.4066 10.4064 15.8286 9.82837L9.00015 3"/>
                            </svg>
                        </summary>
                        <ul class="pm-nav-children">
                            @foreach ($nav['children'] as $child)
                                @if ($child['condition'] ?? true)
                                    <li>
                                        <a href="{{ $child['url'] }}"
                                            class="pm-nav-link {{ $child['active'] ? 'active' : '' }}"
                                            @if($child['spa'] ?? true) wire:navigate @endif>
                                            <x-ri-arrow-right-s-line class="pm-nav-icon" />
                                            <span class="pm-nav-text">{{ $child['name'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </details>
                </li>
            @else
                <li>
                    <a href="{{ $nav['url'] }}"
                        class="pm-nav-link {{ $nav['active'] ? 'active' : '' }}"
                        @if($nav['spa'] ?? true) wire:navigate @endif>
                        @isset($nav['icon'])
                            <x-dynamic-component :component="$nav['icon']" class="pm-nav-icon" />
                        @endisset
                        <span class="pm-nav-text">{{ $nav['name'] }}</span>
                        @if(str_contains($nav['url'], '/services') && auth()->check())
                            <span class="pm-nav-extra">{{ auth()->user()->services()->count() }}</span>
                        @elseif(str_contains($nav['url'], '/invoices') && auth()->check())
                            <span class="pm-nav-extra">{{ auth()->user()->invoices()->where('status', 'pending')->count() }}</span>
                        @elseif(str_contains($nav['url'], '/tickets') && auth()->check())
                            <span class="pm-nav-extra">{{ auth()->user()->tickets()->where('status', '!=', 'closed')->count() }}</span>
                        @endif
                    </a>
                </li>
            @endif
        @endforeach

        @foreach ($topLinks as $nav)
            @if (!empty($nav['children']))
                @foreach ($nav['children'] as $child)
                    <li>
                        <a href="{{ $child['url'] }}"
                            class="pm-nav-link {{ $child['active'] ? 'active' : '' }}"
                            @if($child['spa'] ?? true) wire:navigate @endif>
                            <x-ri-shopping-bag-4-line class="pm-nav-icon" />
                            <span class="pm-nav-text">{{ $child['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            @else
                <li>
                    <a href="{{ $nav['url'] }}"
                        class="pm-nav-link {{ $nav['active'] ? 'active' : '' }}"
                        @if($nav['spa'] ?? true) wire:navigate @endif>
                        @isset($nav['icon'])
                            <x-dynamic-component :component="$nav['icon']" class="pm-nav-icon" />
                        @endisset
                        <span class="pm-nav-text">{{ $nav['name'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
