<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? App\Models\Setting::get('site_name', 'Shohayok') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css-final.css') }}">
    <style>
        .support-fab {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 1080;
            border-radius: 999px;
            width: 58px;
            height: 58px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .18)
        }

        .support-box {
            position: fixed;
            right: 24px;
            bottom: 92px;
            width: min(360px, calc(100vw - 32px));
            z-index: 1079;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .2);
            overflow: hidden
        }

        .support-scroll {
            max-height: 260px;
            overflow: auto;
            background: #f8fafc
        }

        .msg {
            padding: 8px 10px;
            border-radius: 12px;
            margin: 5px 0;
            max-width: 88%;
            font-size: .9rem
        }

        .msg.user {
            margin-left: auto;
            background: #1268e8;
            color: #fff
        }

        .msg.admin {
            background: #fff;
            border: 1px solid #e5e7eb
        }

        .map-canvas {
            min-height: 360px;
            border-radius: 18px;
            background: #e8eef5
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid px-lg-5"><a class="brand-logo me-4" href="{{ route('home') }}"
                aria-label="Shohayok home"><img src="{{ asset('images/shohayok-logo.png') }}" alt="Shohayok"></a><button
                class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">☰</button>
            <div id="nav" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto gap-lg-2">
                    <li class="nav-item"><a class="nav-link text-primary fw-semibold"
                            href="{{ route('explore', ['type' => 'service']) }}">{{ __('ui.services') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('explore', ['type' => 'rental']) }}">{{ __('ui.rent') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">{{ __('ui.about') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">{{ __('ui.contact') }}</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2"><a class="btn btn-light border"
                        href="{{ route('language.switch', app()->getLocale() === 'bn' ? 'en' : 'bn') }}">🌐
                        {{ __('ui.language') }}</a>@auth @if (auth()->user()->isProvider())
                        <a class="btn btn-outline-primary"
                            href="{{ route('provider.dashboard') }}">{{ __('ui.dashboard') }}</a>
                    @elseif(auth()->user()->isAdmin())
                        <a class="btn btn-outline-primary"
                        href="{{ route('admin.dashboard') }}">{{ __('ui.admin') }}</a>@else
                        <a class="btn btn-outline-primary" href="{{ route('profile.show') }}">Profile</a><a
                            class="btn btn-outline-success"
                            href="{{ route('provider.apply') }}">{{ __('ui.become_provider') }}</a>
                    @endif
                    <form method="post" action="{{ route('logout') }}">
                    @csrf<button class="btn btn-outline-secondary">{{ __('ui.logout') }}</button></form>@else<a
                        class="btn btn-outline-primary" href="{{ route('login') }}">{{ __('ui.login') }}</a><a
                    class="btn btn-primary" href="{{ route('register') }}">{{ __('ui.register') }}</a>@endauth
            </div>
        </div>
    </div>
</nav>
@if (session('success'))
    <div class="container mt-3">
        <div class="alert alert-success">{{ session('success') }}</div>
    </div>
@endif
@if ($errors->any())
    <div class="container mt-3">
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    </div>
@endif
@yield('content')
<footer class="shohayok-footer">

    <div class="shohayok-footer-inner">

        <div class="shohayok-footer-grid">

            <div class="footer-brand-block">
                <a href="{{ route('home') }}" class="footer-brand-link">
                    <img
                        src="{{ asset('images/shohayok-logo.png') }}"
                        alt="Shohayok"
                        class="footer-main-logo"
                    >
                </a>

                <p class="footer-about-text">
                    বিশ্বস্ত সার্ভিস, রেন্টাল ও নেয়ারবাই সমাধান—
                    একটি প্ল্যাটফর্মে।
                </p>
            </div>

            <div class="footer-column">
                <h5>Quick Links</h5>

                <a href="{{ route('about') }}">About Us</a>
                <a href="{{ route('how-it-works') }}">How It Works</a>
                <a href="{{ route('faq') }}">FAQ</a>
            </div>

            <div class="footer-column">
                <h5>For Users</h5>

                <a href="{{ route('explore', ['type' => 'service']) }}">
                    Find Services
                </a>

                <a href="{{ route('explore', ['type' => 'rental']) }}">
                    Find Rentals
                </a>
            </div>

            <div class="footer-column footer-contact-column">
                <h5>Contact Us</h5>

                <div class="footer-contact-item">
                    <span>☎</span>
                    <span>+8801301879895</span>
                </div>

                <div class="footer-contact-item">
                    <span>✉</span>
                    <span>info@shohayok.com</span>
                </div>

                <div class="footer-contact-item">
                    <span>📍</span>
                    <span>Naogaon Sadar, Rajshahi, Bangladesh</span>
                </div>
            </div>

        </div>

        <div class="shohayok-footer-bottom">
            <span>© 2026 Shohayok. All rights reserved.</span>
            <span>Created by Estiak Ahamed.</span>
        </div>

    </div>

</footer>

@auth
    @if (!auth()->user()->isAdmin())
        @php(
    $widgetMessages = App\Models\SupportMessage::where('user_id', auth()->id())->latest()->limit(5)->get()->reverse()
)
        <button class="btn btn-primary support-fab" type="button" data-bs-toggle="collapse"
            data-bs-target="#supportWidget" aria-label="Support">💬</button>
        <div class="collapse support-box" id="supportWidget">
            <div class="p-3 border-bottom d-flex justify-content-between"><b>Shohayok Support</b><a
                    href="{{ route('support.messages') }}" class="small">{{ __('ui.messages') }}</a></div>
            <div class="support-scroll p-3">
                @forelse($widgetMessages as $m)
                <div class="msg {{ $m->is_from_admin ? 'admin' : 'user' }}">{{ $m->message }}</div>@empty<div
                        class="text-secondary small">Send a message and the admin team will reply here.</div>
                @endforelse
            </div>
            <form class="p-3" method="post" action="{{ route('support.messages.store') }}">@csrf
                <textarea class="form-control mb-2" rows="2" name="message" maxlength="3000" required
                    placeholder="Write your message to Shohayok Support..."></textarea><button class="btn btn-primary w-100">{{ __('ui.send_message') }}</button>
            </form>
        </div>
    @endif
@endauth
</body>

</html>
