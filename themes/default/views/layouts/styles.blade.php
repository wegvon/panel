<style>
    html {
        background: #d8d6d6;
    }

    body {
        font-family: "Manrope", ui-sans-serif, system-ui, sans-serif;
        letter-spacing: 0;
    }

    .paymenter-body {
        min-height: 100svh;
        background: radial-gradient(circle at 50% 100%, rgba(255, 255, 255, 0.42), transparent 34rem), #d8d6d6;
        color: #11111a;
    }

    .paymenter-shell {
        width: min(1460px, calc(100% - 68px));
        min-height: min(900px, calc(100svh - 68px));
        margin: 34px auto;
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.72);
        border-radius: 28px;
        background: #fff;
        box-shadow: 0 40px 90px rgba(35, 31, 29, 0.18);
    }

    .paymenter-sidebar {
        min-height: 0;
        display: flex;
        flex-direction: column;
        padding: 42px 30px 34px;
        border-right: 1px solid #e8e5e1;
        background: #fff;
    }

    .paymenter-main {
        min-width: 0;
        min-height: 0;
        display: flex;
        flex-direction: column;
        padding: 42px 64px 34px;
        overflow: auto;
        background: #fff;
    }

    .paymenter-main .container {
        width: 100%;
        max-width: none;
        margin: 0;
        padding: 0;
    }

    .pm-brand {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 64px;
        color: #11111a;
        text-decoration: none;
    }

    .pm-brand-mark {
        width: 36px;
        height: 36px;
        color: #0f1020;
        flex: 0 0 auto;
    }

    .pm-brand-name {
        font-size: 23px;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .pm-nav-list,
    .pm-utility-list {
        display: grid;
        gap: 20px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pm-nav-link,
    .pm-utility-link {
        display: flex;
        align-items: center;
        gap: 16px;
        color: #78767b;
        text-decoration: none;
        font-size: 15px;
        font-weight: 750;
        transition: color 160ms ease, transform 160ms ease;
    }

    button.pm-nav-link {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-family: inherit;
        text-align: left;
    }

    .pm-nav-link:hover,
    .pm-utility-link:hover,
    .pm-nav-link.active {
        color: #11111a;
        transform: translateX(2px);
    }

    .pm-nav-icon,
    .pm-utility-icon {
        width: 25px;
        text-align: center;
        font-size: 18px;
        color: currentColor;
        flex: 0 0 auto;
    }

    .pm-nav-extra {
        min-width: 22px;
        height: 22px;
        margin-left: auto;
        padding: 0 7px;
        display: grid;
        place-items: center;
        border-radius: 999px;
        background: #f2f1f0;
        color: #11111a;
        font-size: 11px;
        box-shadow: 0 8px 16px rgba(17, 17, 26, 0.08);
    }

    .pm-nav-chevron {
        width: 18px;
        height: 18px;
        margin-left: auto;
        flex: 0 0 auto;
        transition: transform 200ms ease;
    }

    .pm-nav-chevron.rotate-90 {
        transform: rotate(90deg);
    }

    .pm-nav-children {
        margin: 0;
        padding: 0 0 0 18px;
        list-style: none;
        display: grid;
        gap: 14px;
    }

    .pm-nav-children .pm-nav-link {
        font-size: 14px;
        font-weight: 650;
    }

    .pm-upgrade-card {
        margin-top: auto;
        margin-bottom: 38px;
        padding: 28px 20px;
        border-radius: 18px;
        background: linear-gradient(180deg, #f8f8f7 0%, #f0efed 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.75), 0 22px 50px rgba(18, 17, 15, 0.06);
        text-align: center;
    }

    .pm-upgrade-card h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .pm-upgrade-card p {
        margin: 12px auto 22px;
        max-width: 160px;
        color: #706e73;
        font-size: 14px;
        line-height: 1.65;
    }

    .pm-page {
        display: flex;
        min-height: 100%;
        flex-direction: column;
    }

    .pm-top-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 28px;
    }

    .pm-eyebrow {
        margin: 0 0 8px;
        color: #9d9a98;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .pm-headline {
        margin: 0;
        font-size: clamp(32px, 3.4vw, 42px);
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -0.055em;
    }

    .pm-subhead {
        margin: 14px 0 0;
        color: #77757d;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.6;
    }

    .pm-divider {
        height: 1px;
        margin: 28px 0 22px;
        background: #e8e5e1;
    }

    .pm-round-button {
        width: 42px;
        height: 42px;
        display: inline-grid;
        place-items: center;
        border: 0;
        border-radius: 50%;
        background: #f2f1ef;
        color: #11111a;
        box-shadow: 0 10px 24px rgba(24, 22, 20, 0.08);
        transition: transform 160ms ease, background 160ms ease;
        cursor: pointer;
    }

    .pm-round-button:hover {
        transform: translateY(-2px);
        background: #e9e7e4;
    }

    .pm-button {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 0 18px;
        border-radius: 999px;
        background: linear-gradient(180deg, #b9def5 0%, #8dc5ea 100%);
        color: #0f1020;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 14px 30px rgba(115, 176, 214, 0.26);
        transition: transform 180ms ease, box-shadow 180ms ease;
        cursor: pointer;
        border: none;
    }

    .pm-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px rgba(115, 176, 214, 0.36);
    }

    .pm-button-secondary {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 0 17px;
        border-radius: 999px;
        background: #f3f2f1;
        color: #11111a;
        font-size: 14px;
        font-weight: 750;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .pm-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-top: 28px;
    }

    .pm-section-title {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.045em;
    }

    .pm-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        padding-bottom: 24px;
        border-bottom: 1px solid #e8e5e1;
    }

    .pm-stat {
        min-width: 0;
        display: grid;
        grid-template-columns: 52px 1fr;
        gap: 14px;
    }

    .pm-stat+.pm-stat {
        border-left: 1px solid #e8e5e1;
        padding-left: 18px;
    }

    .pm-stat-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #f2f1ef;
        color: #11111a;
        font-size: 20px;
        box-shadow: 0 12px 22px rgba(17, 17, 26, 0.05);
    }

    .pm-stat-label {
        margin: 2px 0 4px;
        font-size: 14px;
        font-weight: 800;
    }

    .pm-stat-value {
        display: inline-flex;
        align-items: baseline;
        gap: 9px;
        max-width: 100%;
        flex-wrap: wrap;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.03em;
        font-variant-numeric: tabular-nums;
    }

    .pm-delta {
        line-height: 1.2;
        font-size: 13px;
        font-weight: 800;
        color: #56b89d;
    }

    .pm-workspace {
        min-height: 0;
        margin-top: 28px;
        display: grid;
        grid-template-columns: minmax(340px, 0.9fr) minmax(430px, 1.1fr);
        gap: 26px;
    }

    .pm-focus {
        min-height: 340px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 28px;
        border-radius: 22px;
        background: radial-gradient(circle at 82% 16%, rgba(153, 204, 238, 0.46), transparent 12rem), linear-gradient(155deg, #f7f7f5 0%, #ededeb 100%);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.88), 0 24px 58px rgba(21, 20, 18, 0.08);
    }

    .pm-badge {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        min-height: 34px;
        padding: 0 13px;
        border-radius: 999px;
        background: #fff;
        color: #3b8ab2;
        font-size: 12px;
        font-weight: 800;
        box-shadow: 0 12px 26px rgba(25, 23, 21, 0.06);
    }

    .pm-mini-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 28px;
    }

    .pm-mini-metric {
        padding: 15px 14px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.72);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
    }

    .pm-mini-metric span {
        display: block;
        color: #817e7b;
        font-size: 11px;
        font-weight: 800;
    }

    .pm-mini-metric strong {
        display: block;
        margin-top: 7px;
        font-size: 18px;
        font-weight: 850;
        letter-spacing: -0.035em;
    }

    .pm-list {
        display: grid;
        gap: 14px;
    }

    .pm-row {
        display: grid;
        grid-template-columns: 50px minmax(0, 1fr) auto;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: 1px solid rgba(232, 229, 225, 0.88);
        border-radius: 18px;
        background: #fff;
        color: #11111a;
        text-decoration: none;
        box-shadow: 0 18px 42px rgba(26, 24, 22, 0.045);
        transition: transform 160ms ease, box-shadow 160ms ease, border-color 160ms ease;
    }

    .pm-row:hover {
        transform: translateY(-2px);
        border-color: #ddd8d2;
        box-shadow: 0 22px 48px rgba(26, 24, 22, 0.075);
    }

    .pm-row-icon {
        width: 50px;
        height: 50px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #eef4fb;
        color: #11111a;
        font-size: 17px;
    }

    .pm-row-icon.sand {
        background: #faecd8;
    }

    .pm-row-icon.gray {
        background: #f0f0ef;
    }

    .pm-row-title {
        margin: 0;
        font-size: 15px;
        font-weight: 850;
        letter-spacing: -0.025em;
    }

    .pm-row-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 5px;
        color: #77757d;
        font-size: 12px;
        font-weight: 750;
    }

    .pm-row-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pm-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        color: #11111a;
        font-size: 13px;
        font-weight: 850;
    }

    .pm-status::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #56b89d;
    }

    .pm-status.warn::before {
        background: #e8b877;
    }

    .pm-status.bad::before {
        background: #f26368;
    }

    .pm-panel {
        padding: 24px;
        border: 1px solid rgba(232, 229, 225, 0.88);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 18px 42px rgba(26, 24, 22, 0.045);
    }

    .pm-table-wrap {
        overflow-x: auto;
        border: 1px solid rgba(232, 229, 225, 0.88);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 18px 42px rgba(26, 24, 22, 0.045);
    }

    .pm-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pm-table th,
    .pm-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #e8e5e1;
        text-align: left;
        vertical-align: middle;
    }

    .pm-table th {
        color: #77757d;
        font-size: 12px;
        font-weight: 850;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .pm-table td {
        color: #11111a;
        font-size: 14px;
        font-weight: 650;
    }

    .pm-empty {
        padding: 40px;
        border: 1px dashed #d8d4cf;
        border-radius: 20px;
        background: #f8f8f7;
        color: #77757d;
        font-size: 15px;
        font-weight: 650;
        text-align: center;
    }

    .paymenter-main input:not([type="checkbox"]):not([type="radio"]),
    .paymenter-main textarea,
    .paymenter-main select {
        border-color: #e8e5e1;
        border-radius: 14px;
        background-color: #f8f8f7;
        color: #11111a;
        box-shadow: none;
    }

    .paymenter-main label {
        color: #77757d;
        font-weight: 800;
    }

    .paymenter-main .bg-background-secondary {
        background-color: #fff;
        border-color: #e8e5e1;
    }

    .paymenter-main .rounded-lg,
    .paymenter-main .rounded-md {
        border-radius: 18px;
    }

    .pm-reveal {
        animation: pmFadeUp 680ms cubic-bezier(.22, 1, .36, 1) both;
    }

    @keyframes pmFadeUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1260px) {
        .paymenter-shell {
            width: 100%;
            min-height: 100svh;
            margin: 0;
            border-radius: 0;
            grid-template-columns: 92px minmax(0, 1fr);
        }

        .paymenter-sidebar {
            padding: 28px 22px;
            align-items: center;
        }

        .pm-brand-name,
        .pm-nav-text,
        .pm-nav-extra,
        .pm-nav-chevron,
        .pm-nav-children,
        .pm-upgrade-card,
        .pm-utility-list {
            display: none;
        }

        .pm-brand {
            margin-bottom: 48px;
        }

        .pm-nav-link {
            justify-content: center;
        }

        .paymenter-main {
            padding: 30px 36px 26px;
        }

        .pm-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .pm-stat+.pm-stat {
            border-left: 0;
            padding-left: 0;
        }

        .pm-workspace {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .paymenter-shell {
            display: block;
            overflow: auto;
        }

        .paymenter-sidebar {
            position: sticky;
            top: 0;
            z-index: 5;
            flex-direction: row;
            justify-content: space-between;
            border-right: 0;
            border-bottom: 1px solid #e8e5e1;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(20px);
        }

        .pm-brand {
            margin: 0;
        }

        .pm-nav-list {
            display: flex;
            gap: 11px;
        }

        .paymenter-main {
            padding: 28px 18px;
            overflow: visible;
        }

        .pm-top-row,
        .pm-section-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .pm-stats,
        .pm-mini-grid {
            grid-template-columns: 1fr;
        }

        .pm-row {
            grid-template-columns: 44px 1fr;
        }

        .pm-row>:last-child {
            grid-column: 2;
        }
    }
</style>
