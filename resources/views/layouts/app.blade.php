<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nexus Shop') — Premium Online Store</title>
    <meta name="description" content="@yield('meta_description', 'Discover curated products across electronics, fashion, home goods, and more at Nexus Shop.')">

    {{-- Tailwind CSS via CDN (replace with compiled asset in production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#f0f4ff',
                            100: '#e0eaff',
                            500: '#4f6ef7',
                            600: '#3b57f5',
                            700: '#2d45e0',
                            900: '#1a2d9c',
                        },
                        surface: {
                            50:  '#fafafa',
                            100: '#f4f4f5',
                            200: '#e4e4e7',
                            800: '#27272a',
                            900: '#18181b',
                        }
                    },
                    fontFamily: {
                        sans:    ['"DM Sans"', 'system-ui', 'sans-serif'],
                        display: ['"Fraunces"', 'Georgia', 'serif'],
                    },
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Fraunces:ital,wght@0,300;0,600;0,800;1,300;1,600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', system-ui, sans-serif; }
        .font-display { font-family: 'Fraunces', Georgia, serif; }
        [x-cloak] { display: none !important; }

        /* Smooth cart badge pulse */
        @keyframes pop { 0%,100% { transform: scale(1); } 50% { transform: scale(1.25); } }
        .cart-badge-pop { animation: pop 0.3s ease; }

        /* Product card image zoom */
        .product-card:hover .product-img { transform: scale(1.06); }
        .product-img { transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    </style>

    @stack('head')
</head>
<body class="bg-white text-zinc-900 antialiased">

    {{-- ── Navigation ──────────────────────────────────────────────────────── --}}
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-zinc-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('shop.home') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-zinc-900 rounded-lg flex items-center justify-center group-hover:bg-brand-600 transition-colors duration-200">
                        <span class="text-white font-bold text-sm font-display">N</span>
                    </div>
                    <span class="font-display font-semibold text-xl tracking-tight text-zinc-900">Nexus<span class="text-brand-600">.</span></span>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('shop.home') }}"
                       class="text-sm font-medium text-zinc-600 hover:text-zinc-900 transition-colors {{ request()->routeIs('shop.home') ? 'text-zinc-900' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('shop.catalog') }}"
                       class="text-sm font-medium text-zinc-600 hover:text-zinc-900 transition-colors {{ request()->routeIs('shop.catalog') ? 'text-zinc-900' : '' }}">
                        Shop
                    </a>

                    {{-- Categories mega-dropdown --}}
                    <div class="relative group">
                        <button class="flex items-center gap-1 text-sm font-medium text-zinc-600 hover:text-zinc-900 transition-colors">
                            Categories
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-56 bg-white rounded-xl shadow-xl border border-zinc-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            @php $navCategories = \App\Models\Category::active()->parentOnly()->ordered()->take(8)->get(); @endphp
                            @foreach($navCategories as $cat)
                                <a href="{{ route('shop.catalog', ['category' => $cat->slug]) }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-zinc-700 hover:bg-zinc-50 hover:text-zinc-900 transition-colors">
                                    <span class="w-2 h-2 rounded-full bg-brand-500 opacity-60"></span>
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </nav>

                {{-- Right side actions --}}
                <div class="flex items-center gap-2">

                    {{-- Search --}}
                    <button onclick="document.getElementById('searchModal').classList.remove('hidden')"
                            class="p-2 rounded-lg text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>

                    {{-- Cart --}}
                    <a href="{{ route('shop.cart.index') }}" class="relative p-2 rounded-lg text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @php
                            $cartCount = 0;
                            if (auth()->check()) {
                                $cartCount = auth()->user()->cart?->total_items ?? 0;
                            } else {
                                $guestCart = \App\Models\Cart::where('session_id', session()->getId())->first();
                                $cartCount = $guestCart?->total_items ?? 0;
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-brand-600 rounded-full">
                                {{ $cartCount > 9 ? '9+' : $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Account --}}
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-lg hover:bg-zinc-100 transition-all">
                                <div class="w-7 h-7 bg-brand-100 rounded-full flex items-center justify-center">
                                    <span class="text-brand-700 text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <span class="hidden sm:block text-sm font-medium text-zinc-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            </button>
                            <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-zinc-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-zinc-700 hover:bg-zinc-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                        Admin Panel
                                    </a>
                                    <div class="border-t border-zinc-100 my-1"></div>
                                @endif
                                <form method="POST" action="{{ route('auth.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('auth.login') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-zinc-700 hover:text-zinc-900 hover:bg-zinc-100 rounded-lg transition-all">
                            Sign In
                        </a>
                        <a href="{{ route('auth.register') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-zinc-900 hover:bg-zinc-700 rounded-lg transition-all shadow-sm">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success') || session('error'))
        <div id="flashMessage" class="fixed top-20 right-4 z-50 max-w-sm animate-in">
            @if(session('success'))
                <div class="flex items-start gap-3 bg-white border border-green-200 text-zinc-800 px-4 py-3 rounded-xl shadow-lg">
                    <div class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500 flex items-center justify-center mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                    <button onclick="this.closest('#flashMessage').remove()" class="ml-auto text-zinc-400 hover:text-zinc-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-start gap-3 bg-white border border-red-200 text-zinc-800 px-4 py-3 rounded-xl shadow-lg">
                    <div class="flex-shrink-0 w-5 h-5 rounded-full bg-red-500 flex items-center justify-center mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                    <button onclick="this.closest('#flashMessage').remove()" class="ml-auto text-zinc-400 hover:text-zinc-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
        </div>
        <script>setTimeout(() => { const f = document.getElementById('flashMessage'); if (f) f.remove(); }, 5000);</script>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-zinc-950 text-zinc-400 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="md:col-span-1">
                    <a href="{{ route('shop.home') }}" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <span class="text-zinc-900 font-bold text-sm font-display">N</span>
                        </div>
                        <span class="font-display font-semibold text-xl text-white">Nexus<span class="text-brand-500">.</span></span>
                    </a>
                    <p class="text-sm leading-relaxed">Premium products, curated for people who care about quality and design.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-widest">Shop</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('shop.catalog') }}" class="hover:text-white transition-colors">All Products</a></li>
                        <li><a href="{{ route('shop.catalog', ['sort' => 'latest']) }}" class="hover:text-white transition-colors">New Arrivals</a></li>
                        <li><a href="{{ route('shop.catalog', ['sort' => 'popular']) }}" class="hover:text-white transition-colors">Best Sellers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-widest">Support</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('shop.help') }}" class="hover:text-white transition-colors">Help Centre</a></li>
<li><a href="{{ route('shop.shipping') }}" class="hover:text-white transition-colors">Shipping Policy</a></li>
<li><a href="{{ route('shop.returns') }}" class="hover:text-white transition-colors">Returns & Refunds</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-widest">Account</h4>
                    <ul class="space-y-2.5 text-sm">
                      @auth
    @if(!auth()->user()->isAdmin())
        <li><a href="{{ route('shop.cart.index') }}" class="hover:text-white transition-colors">My Cart</a></li>
    @else
        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Admin Panel</a></li>
    @endif
    <li>
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="hover:text-white transition-colors text-left">Sign Out</button>
        </form>
    </li>
@else
                            <li><a href="{{ route('auth.login') }}" class="hover:text-white transition-colors">Sign In</a></li>
                            <li><a href="{{ route('auth.register') }}" class="hover:text-white transition-colors">Create Account</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="border-t border-zinc-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs">© {{ date('Y') }} Nexus Shop. All rights reserved.</p>
                <div class="flex items-center gap-6 text-xs">
                    <a href="{{ route('shop.privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a>
<a href="{{ route('shop.terms') }}" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Search Modal --}}
    <div id="searchModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-start justify-center pt-20 px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl">
            <form action="{{ route('shop.catalog') }}" method="GET" class="flex items-center gap-3 p-4">
                <svg class="w-5 h-5 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Search products, brands..."
                       class="flex-1 text-zinc-900 placeholder-zinc-400 text-lg outline-none bg-transparent"
                       autofocus>
                <button type="button" onclick="document.getElementById('searchModal').classList.add('hidden')"
                        class="p-1 text-zinc-400 hover:text-zinc-700 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('searchModal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
