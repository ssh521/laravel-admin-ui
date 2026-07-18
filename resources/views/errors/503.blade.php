<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#17102f">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="refresh" content="15">

    <title>{{ __('서비스 업데이트 중입니다') }} | {{ config('app.name', 'Laravel') }}</title>

    <style>
        :root {
            color-scheme: dark;
            font-family: Pretendard, "Apple SD Gothic Neo", "Noto Sans KR", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-synthesis: none;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            min-width: 320px;
            min-height: 100%;
            background: #100a22;
        }

        body {
            min-height: 100vh;
            min-height: 100svh;
            margin: 0;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(circle at 16% 12%, rgba(139, 92, 246, .32), transparent 35%),
                radial-gradient(circle at 86% 88%, rgba(79, 70, 229, .26), transparent 40%),
                linear-gradient(145deg, #100a22 0%, #1b1038 48%, #0d132d 100%);
        }

        body::before,
        body::after {
            position: fixed;
            z-index: 0;
            width: 28rem;
            height: 28rem;
            border-radius: 999px;
            content: "";
            pointer-events: none;
        }

        body::before {
            top: -15rem;
            right: -9rem;
            border: 1px solid rgba(221, 214, 254, .18);
            box-shadow:
                0 0 0 4rem rgba(139, 92, 246, .04),
                0 0 0 9rem rgba(99, 102, 241, .025);
        }

        body::after {
            bottom: -19rem;
            left: -10rem;
            border: 1px solid rgba(196, 181, 253, .14);
            box-shadow: 0 0 0 6rem rgba(124, 58, 237, .035);
        }

        main {
            position: relative;
            z-index: 1;
            display: grid;
            min-height: 100vh;
            min-height: 100svh;
            place-items: center;
            padding:
                max(1.5rem, env(safe-area-inset-top))
                max(1.25rem, env(safe-area-inset-right))
                max(1.5rem, env(safe-area-inset-bottom))
                max(1.25rem, env(safe-area-inset-left));
        }

        .maintenance-card {
            width: min(100%, 42rem);
            padding: clamp(1.5rem, 5vw, 3.25rem);
            overflow: hidden;
            text-align: center;
            background: linear-gradient(145deg, rgba(255, 255, 255, .14), rgba(255, 255, 255, .055));
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: clamp(1.75rem, 5vw, 2.75rem);
            box-shadow:
                0 2rem 5rem rgba(4, 2, 14, .42),
                inset 0 1px 0 rgba(255, 255, 255, .16);
            backdrop-filter: blur(28px) saturate(135%);
            -webkit-backdrop-filter: blur(28px) saturate(135%);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            color: #f5f3ff;
            font-size: 1rem;
            font-weight: 760;
            letter-spacing: -.025em;
        }

        .brand-mark {
            display: grid;
            width: 2.75rem;
            height: 2.75rem;
            place-items: center;
            color: #fff;
            background: linear-gradient(145deg, #8b5cf6, #5b21b6);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: .95rem;
            box-shadow: 0 .75rem 1.75rem rgba(91, 33, 182, .38);
        }

        .brand-mark svg {
            width: 1.55rem;
            height: 1.55rem;
        }

        .eyebrow {
            margin: 2.25rem 0 0;
            color: #d8b4fe;
            font-size: .72rem;
            font-weight: 720;
            letter-spacing: .2em;
            text-transform: uppercase;
        }

        h1 {
            margin: .85rem 0 0;
            font-size: clamp(2rem, 8vw, 3.35rem);
            line-height: 1.16;
            letter-spacing: -.055em;
            text-wrap: balance;
        }

        .message {
            max-width: 31rem;
            margin: 1.15rem auto 0;
            color: rgba(245, 243, 255, .76);
            font-size: clamp(.98rem, 2.8vw, 1.08rem);
            line-height: 1.75;
            word-break: keep-all;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            margin-top: 2rem;
            padding: .65rem .9rem;
            color: rgba(255, 255, 255, .84);
            font-size: .78rem;
            font-weight: 650;
            background: rgba(255, 255, 255, .075);
            border: 1px solid rgba(255, 255, 255, .13);
            border-radius: 999px;
        }

        .status-dot {
            width: .5rem;
            height: .5rem;
            background: #c084fc;
            border-radius: 999px;
            box-shadow: 0 0 0 .28rem rgba(192, 132, 252, .12);
            animation: status-pulse 1.8s ease-in-out infinite;
        }

        .refresh-track {
            width: min(100%, 22rem);
            height: 2px;
            margin: 1.5rem auto 0;
            overflow: hidden;
            background: rgba(255, 255, 255, .1);
            border-radius: 999px;
        }

        .refresh-progress {
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #c084fc, #818cf8);
            box-shadow: 0 0 .8rem rgba(192, 132, 252, .7);
            transform: scaleX(0);
            transform-origin: left;
            animation: refresh-progress 15s linear infinite;
        }

        .refresh-note {
            margin: .8rem 0 0;
            color: rgba(221, 214, 254, .56);
            font-size: .75rem;
        }

        @keyframes status-pulse {
            0%, 100% { opacity: .65; transform: scale(.9); }
            50% { opacity: 1; transform: scale(1.08); }
        }

        @keyframes refresh-progress {
            to { transform: scaleX(1); }
        }

        @media (max-width: 480px) {
            .maintenance-card {
                padding-block: 2rem;
            }

            .eyebrow {
                margin-top: 1.8rem;
                letter-spacing: .16em;
            }

            .message br {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .status-dot,
            .refresh-progress {
                animation: none;
            }

            .refresh-progress {
                transform: scaleX(1);
            }
        }
    </style>
</head>
<body>
    <main>
        <section class="maintenance-card" aria-labelledby="maintenance-title">
            <div class="brand" aria-label="{{ config('app.name', 'Laravel') }}">
                <span class="brand-mark" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <rect x="4" y="4" width="16" height="6" rx="2"/>
                        <rect x="4" y="14" width="16" height="6" rx="2"/>
                        <path d="M8 7h.01M8 17h.01M12 7h4M12 17h4"/>
                    </svg>
                </span>
                <span>{{ config('app.name', 'Laravel') }}</span>
            </div>

            <p class="eyebrow">System Update</p>
            <h1 id="maintenance-title">{{ __('서비스 업데이트 중입니다') }}</h1>
            <p class="message">
                {{ __('더 나은 경험을 위해 잠시 시스템을 정비하고 있습니다.') }}<br>
                {{ __('잠시 후 자동으로 다시 연결됩니다.') }}
            </p>

            <div class="status" role="status">
                <span class="status-dot" aria-hidden="true"></span>
                <span>{{ __('안전하게 업데이트하고 있습니다') }}</span>
            </div>

            <div class="refresh-track" aria-hidden="true">
                <div class="refresh-progress"></div>
            </div>
            <p class="refresh-note">{{ __('15초마다 자동으로 새로고침합니다.') }}</p>
        </section>
    </main>
</body>
</html>
