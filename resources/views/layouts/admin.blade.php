<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Nexus Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#f0f4ff', 100:'#e0eaff', 500:'#4f6ef7', 600:'#3b57f5', 700:'#2d45e0' },
                    },
                    fontFamily: {
                        sans:    ['"DM Sans"', 'system-ui', 'sans-serif'],
                        display: ['"Fraunces"', 'Georgia', 'serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Fraunces:ital,wght@0,300;0,600;1,300&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', system-ui, sans-serif; }
        .font-display { font-family: 'Fraunces', Georgia, serif; }
        .sidebar-link { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.75rem; font-size:0.875rem; font-weight:500; transition:all 0.15s; }
.sidebar-link.active { background:rgba(255,255,255,0.15); color:white; }
.sidebar-link:not(.active) { color:#a1a1aa; }
.sidebar-link:not(.active):hover { background:rgba(255,255,255,0.1); color:white; }
    </style>
    @stack('head')
</head>
<body class="h-full bg-zinc-50">
<div class="flex h-full min-h-screen">

    {{-- ── Sidebar ──────────────────────────────────────────────────────────── --}}
    <aside class="w-64 bg-zinc-950 flex flex-col fixed inset-y-0 left-0 z-30 shadow-2xl">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm font-display">N</span>
            </div>
            <div>
                <p class="font-display font-semibold text-white text-base leading-none">Nexus</p>
                <p class="text-zinc-500 text-xs mt-0.5">Admin Panel</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

            <p class="text-zinc-600 text-xs font-semibold uppercase tracking-widest px-4 mb-2">Overview</p>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>

            <div class="pt-4">
                <p class="text-zinc-600 text-xs font-semibold uppercase tracking-widest px-4 mb-2">Catalog</p>
                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categories
                </a>
            </div>

            <div class="pt-4">
                <p class="text-zinc-600 text-xs font-semibold uppercase tracking-widest px-4 mb-2">Sales</p>
                <a href="{{ route('admin.orders.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Orders
                    @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            </div>
        </nav>

        {{-- User + Back to store --}}
        <div class="px-3 py-4 border-t border-white/10 space-y-1">
            <a href="{{ route('shop.home') }}" target="_blank"
               class="sidebar-link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Store
            </a>
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main content ────────────────────────────────────────────────────── --}}
    <div class="flex-1 ml-64 flex flex-col min-h-screen">

        {{-- Top bar --}}
        <header class="bg-white border-b border-zinc-100 sticky top-0 z-20">
            <div class="px-8 py-4 flex items-center justify-between">
                <div>
                    <h2 class="font-display text-lg font-semibold text-zinc-900">@yield('page-title', 'Dashboard')</h2>
                    @hasSection('page-subtitle')
                        <p class="text-sm text-zinc-400 mt-0.5">@yield('page-subtitle')</p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 text-sm text-zinc-600">
                        <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center">
                            <span class="text-brand-700 font-semibold text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <span class="font-medium">{{ auth()->user()->name }}</span>
                        <span class="px-1.5 py-0.5 bg-brand-100 text-brand-700 text-xs rounded-full font-medium">Admin</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success') || session('error'))
            <div class="mx-8 mt-4">
                @if(session('success'))
                    <div class="flex items-center gap-3 bg-green-50 border border-green-200 px-4 py-3 rounded-xl text-sm text-green-800">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 bg-red-50 border border-red-200 px-4 py-3 rounded-xl text-sm text-red-800">
                        <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 px-8 py-6">
            @yield('content')
        </main>

        <footer class="px-8 py-4 border-t border-zinc-100 text-xs text-zinc-400">
            © {{ date('Y') }} Nexus Shop Admin Panel
        </footer>
    </div>
</div>
@stack('scripts')
</body>
</html>
