<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sir Melvin Blog') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --cream: #FBF7F0;
            --charcoal: #2A2A2A;
            --rust: #B85C38;
            --sage: #7A9B76;
            --navy: #1A3A52;
            --gold: #D4AF37;
        }

        body {
            font-family: 'IBM Plex Sans', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
        }

        /* Top Bar */
        .top-bar {
            background: var(--charcoal);
            color: rgba(251,247,240,0.6);
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 0.5rem 8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar a { color: rgba(251,247,240,0.6); text-decoration: none; transition: color 0.2s; }
        .top-bar a:hover { color: var(--gold); }

        /* Main Nav */
        .main-nav {
            background: var(--cream);
            border-bottom: 2px solid var(--charcoal);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-inner {
            padding: 0 8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 72px;
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: -1px;
            color: var(--charcoal);
            text-decoration: none;
        }

        .nav-logo span { color: var(--rust); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--charcoal);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            padding: 0.5rem 0.85rem;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0.85rem;
            width: 0; height: 2px;
            background: var(--rust);
            transition: width 0.3s;
        }

        .nav-links a:hover { color: var(--rust); }
        .nav-links a:hover::after { width: calc(100% - 1.7rem); }

        .nav-btn {
            padding: 0.6rem 1.4rem;
            background: var(--charcoal);
            color: var(--cream) !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            letter-spacing: 1px !important;
            text-transform: uppercase;
            transition: background 0.3s !important;
        }

        .nav-btn:hover { background: var(--rust) !important; color: white !important; }
        .nav-btn::after { display: none !important; }

        .nav-admin {
            color: var(--gold) !important;
            font-weight: 600 !important;
        }

        /* Dropdown */
        .nav-dropdown { position: relative; }
        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
            color: var(--charcoal);
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.5rem 0.85rem;
            transition: color 0.3s;
        }
        .dropdown-toggle:hover { color: var(--rust); }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%; right: 0;
            background: white;
            border: 1px solid rgba(0,0,0,0.1);
            border-top: 2px solid var(--rust);
            min-width: 180px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .nav-dropdown:hover .dropdown-menu { display: block; }

        .dropdown-menu a, .dropdown-menu button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1.25rem;
            color: var(--charcoal);
            font-size: 0.88rem;
            font-weight: 400;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            letter-spacing: 0;
        }

        .dropdown-menu a:hover, .dropdown-menu button:hover {
            background: var(--cream);
            color: var(--rust);
        }

        /* Mobile toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--charcoal);
        }

        /* Footer */
        .site-footer {
            background: var(--charcoal);
            color: var(--cream);
            padding: 4rem 8rem 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
            margin-bottom: 3rem;
            padding-bottom: 3rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .footer-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: 1rem;
        }

        .footer-brand-name span { color: var(--rust); }

        .footer-desc {
            font-size: 0.9rem;
            color: rgba(251,247,240,0.55);
            line-height: 1.7;
            font-weight: 300;
        }

        .footer-col-title {
            font-size: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 1.25rem;
            font-weight: 600;
        }

        .footer-col a {
            display: block;
            color: rgba(251,247,240,0.6);
            text-decoration: none;
            font-size: 0.88rem;
            margin-bottom: 0.6rem;
            transition: color 0.2s;
        }

        .footer-col a:hover { color: var(--cream); }

        .footer-bottom {
            text-align: center;
            font-size: 0.82rem;
            color: rgba(251,247,240,0.35);
        }

        @media (max-width: 1024px) {
            .top-bar, .nav-inner, .site-footer { padding-left: 2rem; padding-right: 2rem; }
        }

        @media (max-width: 768px) {
            .top-bar { display: none; }
            .nav-inner { padding: 0 1.5rem; }
            .nav-links { display: none; }
            .mobile-toggle { display: block; }
            .site-footer { padding: 3rem 1.5rem 2rem; }
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <span>{{ date('l, F j, Y') }}</span>
        <div style="display:flex; gap:1.5rem;">
            @guest
                <a href="{{ route('login') }}">Sign In</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest
            @auth
                <a href="{{ route('posts.create') }}">Write a Story</a>
            @endauth
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="main-nav">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="nav-logo">Sir Melvin<span>.</span></a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('posts.index') }}">Stories</a></li>

                @auth
                    <li><a href="{{ route('posts.create') }}">Write</a></li>
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>

                    @if(auth()->user()->is_admin)
                        <li><a href="{{ route('admin.users.index') }}" class="nav-admin">Admin</a></li>
                    @endif

                    <li class="nav-dropdown">
                        <div class="dropdown-toggle">
                            {{ Auth::user()->name }}
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                <path d="M6 8L1 3h10z"/>
                            </svg>
                        </div>
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.edit') }}">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                    <li><a href="{{ route('register') }}" class="nav-btn">Get Started</a></li>
                @endauth
            </ul>

            <button class="mobile-toggle" onclick="document.querySelector('.nav-links').style.display = document.querySelector('.nav-links').style.display === 'flex' ? 'none' : 'flex'">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @if(session('success'))
            <div style="background:#7A9B76; color:white; padding:1rem 8rem; font-family:'IBM Plex Sans',sans-serif; font-size:0.9rem;">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#B85C38; color:white; padding:1rem 8rem; font-family:'IBM Plex Sans',sans-serif; font-size:0.9rem;">
                ✕ {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-grid">
            <div>
                <div class="footer-brand-name">Sir Melvin<span>.</span></div>
                <p class="footer-desc">A curated space for stories, ideas, and perspectives from writers who care about craft and meaning.</p>
            </div>
            <div class="footer-col">
                <div class="footer-col-title">Explore</div>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('posts.index') }}">All Stories</a>
                @auth
                <a href="{{ route('posts.create') }}">Write a Story</a>
                @endauth
            </div>
            <div class="footer-col">
                <div class="footer-col-title">Account</div>
                @auth
                <a href="{{ route('profile.edit') }}">Your Profile</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                <a href="{{ route('login') }}">Sign In</a>
                <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Sir Melvin Blog. All rights reserved.
        </div>
    </footer>
</body>
</html>
