# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**ServerHop Panel** — a Laravel 12 hosting billing and management platform. Handles client management, product/service ordering, invoicing, support tickets, and multi-currency billing.

## Stack

- **Backend**: Laravel 12, PHP 8.3+, MariaDB, Redis
- **Admin Panel**: Filament 5 (Laravel admin framework)
- **Frontend**: Livewire 4, Alpine.js, Tailwind CSS 4, Vite 7
- **API**: Laravel Passport (OAuth2), timacdonald/json-api
- **Testing**: PHPUnit 12, MariaDB test database
- **Static Analysis**: Larastan (level 5), Laravel Pint (code style)
- **Containerization**: Docker (multi-stage build), docker-compose

## Commands

```bash
# Local development
composer dev                          # Start queue listener + Vite dev server
npm run dev                           # Vite dev server only
npm run build                         # Production asset build

# Admin panel CSS (separate build from main Vite)
npm run dev:admin                     # Watch Filament admin theme
npm run build:admin                   # Build Filament admin theme (minified)

# Testing
php artisan test                      # Run all tests
php artisan test --filter=TestName    # Run specific test
php artisan test tests/Unit           # Unit tests only
php artisan test tests/Feature        # Feature tests only

# Code quality
vendor/bin/pint                       # Format code (Laravel Pint)
vendor/bin/phpstan analyse            # Static analysis (Larastan, level 5)

# Queue (runs invoices, email, extensions)
php artisan queue:listen --tries=1

# Scheduler (runs cron jobs — invoice generation, service suspension, etc.)
php artisan schedule:run

# Docker
docker compose up -d                  # Start MariaDB + Redis + app
```

## Architecture

### Extension System (Plugin Architecture)

The extension system is the backbone. Extensions live in `extensions/` and are categorized into three types:

| Directory | Type | Examples |
|-----------|------|----------|
| `extensions/Gateways/` | Payment gateways | Stripe, PayPal, Mollie |
| `extensions/Servers/` | Server provisioning | Pterodactyl, Plesk, cPanel, Enhance, DirectAdmin, Virtfusion, Virtualizor |
| `extensions/Others/` | Miscellaneous | Affiliates, Announcements, DiscordNotifications |

Each extension is a PHP class with an `#[ExtensionMeta]` attribute defining its metadata (name, version, author, type). Extensions are discovered and registered by `App\Helpers\ExtensionHelper` via reflection scanning of `extensions/`. Extensions have their own routes (`routes.php`), migrations, views, and configuration — they're self-contained micro-applications.

The `Extension` model stores enabled/disabled state in the database. Extensions hook into the system via events, service classes, and the extension helper.

### Admin Panel (Filament)

The admin panel lives in `app/Admin/` and uses Filament 5:

- **Pages**: `Dashboard`, `Settings`, `Extensions`, `Updates`, `CronStats`
- **Resources**: Full CRUD for all models — `UserResource`, `ServiceResource`, `InvoiceResource`, `OrderResource`, `ProductResource`, `TicketResource`, `CategoryResource`, `ServerResource`, `GatewayResource`, `CouponResource`, `TaxRateResource`, `CurrencyResource`, `RoleResource`, and more
- **Widgets**: Dashboard metrics
- **Clusters**: Grouped admin pages

Admin CSS is built separately from the client theme: `resources/css/filament/admin/theme.css` → `public/css/filament/admin/theme.css`.

### Client-Facing Routes

Routes in `routes/web.php` use Livewire 4 full-page components:

- **Auth**: `Auth\Login`, `Auth\Register`, `Auth\Tfa` (2FA), `Auth\Password\Request`, `Auth\Password\Reset`, `Auth\VerifyEmail`
- **Dashboard**: `customer.dashboard`
- **Services**: `Services\Index`, `Services\Show`, `Services\Upgrade`
- **Invoices**: `Invoices\Index`, `Invoices\Show`
- **Tickets**: `Tickets\Index`, `Tickets\Create`, `Tickets\Show`
- **Account**: `Client\Account`, `Client\Security`, `Client\Credits`, `Client\PaymentMethods`, `Client\Notifications`
- **Store**: `Cart`, `Products\Index`, `Products\Show`, `Products\Checkout`
- **OAuth**: Social login via Laravel Socialite (Discord, etc.)

### REST API

`routes/api.php` — Passport OAuth2-protected, JSON:API format:

- `POST /api/oauth/token` — token issuance
- `GET /api/me` — profile (scope: `profile`)
- `GET/POST/PUT/DELETE /api/v1/admin/*` — admin CRUD (categories, users, products, services, orders, invoices, tickets, credits)

### Key Models (50+ Eloquent models)

Core domain models: `User`, `Service`, `Product`, `Category`, `Order`, `Invoice`, `InvoiceItem`, `InvoiceTransaction`, `Ticket`, `TicketMessage`, `Server`, `Gateway`, `Extension`, `Coupon`, `TaxRate`, `Currency`, `Credit`, `Cart`, `CartItem`, `Plan`, `Price`, `ConfigOption`, `Role`, `Notification`, `BillingAgreement`

### Livewire Components

`app/Livewire/` — full-page components organized by domain:
- `Auth/` — login, register, 2FA, password reset, email verification
- `Services/`, `Products/`, `Invoices/`, `Tickets/`, `Cart.php`
- `Client/` — account, security, credits, payment methods, notifications
- `Components/` — shared/reusable components
- `Traits/` — shared Livewire traits

### Service Layer

`app/Services/` — business logic for invoice generation, service provisioning/upgrades, and extension lifecycle.

### Events, Listeners & Observers

- `app/Events/` — domain events
- `app/Listeners/` — event handlers
- `app/Observers/` — Eloquent model observers (auditing via `owen-it/laravel-auditing`)

### Console Commands

`app/Console/Commands/` — `CronJob.php` (the main scheduler task), `FetchEmails.php` (ticket email piping), `CheckForUpdates.php`, `ImportFromWhmcs.php`, `TelemetryCommand.php`, and extension/upgrade related commands.

### Themes

`themes/default/` — the default client-facing theme. Contains its own `views/`, `css/`, `js/`, `theme.php` config, and `vite.config.js`. Uses `qirolab/laravel-themer` for theme management.

### Configuration

- `config/permissions.php` — role-based permission tree (admin → settings, users, invoices, services, tickets, etc.)
- `config/app.php` — app name, version, telemetry toggle
- `config/audit.php` — model auditing config
- `config/passport.php` — OAuth2 server config
- `config/livewire.php` — Livewire configuration

## Docker

Multi-stage Docker build (PHP 8.3 FPM Alpine + Nginx + Supervisor). MariaDB + Redis in docker-compose. The entrypoint renews default themes/extensions from baked-in copies on startup unless `PAYMENTER_SKIP_DEFAULT=true`.

## Key Patterns

- **PHP 8.3+ attributes**: `#[ExtensionMeta]` for extension discovery, `#[DisabledIf]` for conditional field disabling
- **Eloquent Builders**: Custom query builders in `app/Models/Builders/`
- **Traits**: Shared model behavior in `app/Models/Traits/`
- **JSON:API**: API responses use `timacdonald/json-api` for spec-compliant responses
- **Scramble**: API documentation auto-generated via `dedoc/scramble` (config in `config/scramble.php`)