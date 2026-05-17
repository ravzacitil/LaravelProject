@extends('layouts.app')
@section('title', 'Create Account')

@section('content')
<div class="min-h-screen bg-surface-50 flex items-center justify-center py-16 px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-10">
            <a href="{{ route('shop.home') }}" class="inline-flex items-center gap-2 group">
                <div class="w-10 h-10 bg-zinc-900 rounded-xl flex items-center justify-center group-hover:bg-brand-600 transition-colors">
                    <span class="text-white font-bold font-display">N</span>
                </div>
                <span class="font-display font-semibold text-2xl text-zinc-900">Nexus<span class="text-brand-600">.</span></span>
            </a>
            <h1 class="font-display text-3xl font-semibold text-zinc-900 mt-6 mb-1">Create your account</h1>
            <p class="text-zinc-500">Join thousands of happy customers</p>
        </div>

        <div class="bg-white rounded-2xl border border-zinc-100 shadow-sm p-8">

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700 mb-1.5">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                           class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all text-sm @error('name') border-red-400 @enderror"
                           placeholder="James Anderson">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700 mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all text-sm @error('email') border-red-400 @enderror"
                           placeholder="you@example.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                           class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all text-sm"
                           placeholder="At least 8 characters">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 mb-1.5">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all text-sm"
                           placeholder="Repeat your password">
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-zinc-900 text-white font-semibold text-sm py-3.5 rounded-xl hover:bg-brand-600 transition-all shadow-lg shadow-zinc-900/10 active:scale-[0.98]">
                    Create Account
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </button>

                <p class="text-xs text-zinc-400 text-center pt-1">
                    By creating an account you agree to our
                    <a href="#" class="text-brand-600 hover:underline">Terms of Service</a> and
                    <a href="#" class="text-brand-600 hover:underline">Privacy Policy</a>.
                </p>
            </form>
        </div>

        <p class="text-center mt-6 text-sm text-zinc-500">
            Already have an account?
            <a href="{{ route('auth.login') }}" class="text-brand-600 font-semibold hover:text-brand-700 transition-colors ml-1">Sign in</a>
        </p>
    </div>
</div>
@endsection
