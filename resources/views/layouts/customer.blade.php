<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ServerHop - Client Console')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
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
            font-family: "Manrope", system-ui, sans-serif;
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            background:
                radial-gradient(circle at 50% 100%, rgba(255, 255, 255, 0.42), transparent 34rem),
                var(--page);
        }

        .app-shell {
            width: min(1460px, 100%);
            min-height: 900px;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.72);
            border-radius: 28px;
            background: var(--panel);
            box-shadow: var(--shadow);
            margin: 34px auto;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            padding: 42px 30px 34px;
            border-right: 1px solid var(--line);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 64px;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            color: #0f1020;
        }

        .brand-name {
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .nav-list, .utility-list {
            display: grid;
            gap: 20px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .nav-link, .utility-link {
            display: flex;
            align-items: center;
            gap: 16px;
            color: #78767b;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            transition: color 160ms ease, transform 160ms ease;
        }

        .nav-link:hover, .utility-link:hover {
            color: var(--ink);
            transform: translateX(2px);
        }

        .nav-link.active {
            color: var(--ink);
        }

        .nav-icon, .utility-icon {
            width: 25px;
            text-align: center;
            font-size: 18px;
            color: currentColor;
        }

        .main {
            display: flex;
            flex-direction: column;
            padding: 42px 64px 34px;
            overflow: hidden;
        }

        .top-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 28px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: #9d9a98;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .headline {
            margin: 0;
            font-size: clamp(32px, 3.4vw, 42px);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -0.055em;
        }

        .subhead {
            margin: 14px 0 0;
            color: #77757d;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.6;
        }

        .upgrade-card {
            margin-top: auto;
            margin-bottom: 38px;
            padding: 28px 20px;
            border-radius: 18px;
            background: linear-gradient(180deg, #f8f8f7 0%, #f0efed 100%);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.75), 0 22px 50px rgba(18, 17, 15, 0.06);
            text-align: center;
        }

        .upgrade-card h3 {
            margin: 0;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .upgrade-card p {
            margin: 12px auto 22px;
            max-width: 160px;
            color: #706e73;
            font-size: 14px;
            line-height: 1.65;
        }

        .upgrade-card button {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 18px;
            border: none;
            border-radius: 999px;
            background: linear-gradient(180deg, #b9def5 0%, #8dc5ea 100%);
            color: #0f1020;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 14px 30px rgba(115, 176, 214, 0.26);
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .upgrade-card button:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(115, 176, 214, 0.36);
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="brand">
                <svg class="brand-mark" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="36" height="36" rx="10" fill="#11111a"/>
                    <path d="M10 18L16 24L26 12" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="brand-name">ServerHop</span>
            </div>

            <ul class="nav-list">
                <li><a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard', 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <span>Dashboard</span>
                </a></li>
                <li><a href="{{ route('customer.services') }}" class="nav-link {{ request()->routeIs('customer.services', 'services') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-server"></i>
                    <span>My Services</span>
                </a></li>
                <li><a href="{{ route('customer.invoices') }}" class="nav-link {{ request()->routeIs('customer.invoices', 'invoices') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <span>Invoices</span>
                </a></li>
                <li><a href="{{ route('customer.payments') }}" class="nav-link {{ request()->routeIs('customer.payments') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-credit-card"></i>
                    <span>Payments</span>
                </a></li>
                <li><a href="{{ route('customer.tickets') }}" class="nav-link {{ request()->routeIs('customer.tickets', 'tickets') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-headset"></i>
                    <span>Support Tickets</span>
                </a></li>
                <li><a href="{{ route('customer.domains') }}" class="nav-link {{ request()->routeIs('customer.domains') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-globe"></i>
                    <span>Domains</span>
                </a></li>
            </ul>

            <div class="upgrade-card">
                <h3>Upgrade to Pro</h3>
                <p>Unlock advanced features and priority support.</p>
                <button>Upgrade Now</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main">
            @yield('content')
        </div>
    </div>
</body>
</html>