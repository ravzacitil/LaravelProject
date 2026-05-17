@extends('layouts.app')
@section('title', 'Sign In')

@section('content')
<div class="min-h-screen bg-surface-50 flex items-center justify-center py-16 px-4">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-10">
            <a href="{{ route('shop.home') }}" class="inline-flex items-center gap-2 group">
                <div class="w-10 h-10 bg-zinc-900 rounded-xl flex items-center justify-center group-hover:bg-brand-600 transition-colors">
                    <span class="text-white font-bold font-display">N</span>
                </div>
                <span class="font-display font-semibold text-2xl text-zinc-900">Nexus<span class="text-brand-600">.</span></span>
            </a>
            <h1 class="font-display text-3xl font-semibold text-zinc-900 mt-6 mb-1">Welcome back</h1>
            <p class="text-zinc-500">Sign in to your account to continue</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-zinc-100 shadow-sm p-8">

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700 mb-1.5">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all text-sm text-zinc-900 placeholder-zinc-400 @error('email') border-red-400 @enderror"
                           placeholder="you@example.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-zinc-700">Password</label>
                        <a href="#" class="text-xs text-brand-600 hover:text-brand-700 transition-colors font-medium">Forgot password?</a>
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all text-sm text-zinc-900 placeholder-zinc-400"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-zinc-300 text-brand-600 focus:ring-brand-500">
                    <label for="remember" class="text-sm text-zinc-600">Keep me signed in</label>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-zinc-900 text-white font-semibold text-sm py-3.5 rounded-xl hover:bg-brand-600 transition-all shadow-lg shadow-zinc-900/10 active:scale-[0.98]">
                    Sign In
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-sm text-zinc-500">
            Don't have an account?
            <a href="{{ route('auth.register') }}" class="text-brand-600 font-semibold hover:text-brand-700 transition-colors ml-1">Create one</a>
        </p>

        {{-- Demo credentials --}}
        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700">
            <p class="font-semibold mb-1">Demo Credentials</p>
            <p>Admin: <span class="font-mono">admin@nexusshop.com</span> / <span class="font-mono">password</span></p>
            <p>Customer: <span class="font-mono">customer@nexusshop.com</span> / <span class="font-mono">password</span></p>
        </div>
    </div>
</div>
@endsection
