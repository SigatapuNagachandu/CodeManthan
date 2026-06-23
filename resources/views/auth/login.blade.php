@extends('layouts.app')

@section('title', 'Sign In - CodeManthan Security Hub')

@section('content')
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center bg-monochrome-mesh py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        
        <!-- Platform Branding Header -->
        <div class="text-center">
            <div class="w-12 h-12 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white flex items-center justify-center font-black text-lg mx-auto mb-4">
                L
            </div>
            <h2 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white">
                Platform Security Login
            </h2>
            <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550">
                CodeManthan screening credentials gates
            </p>
        </div>

        <!-- Glassmorphism Form Card -->
        <div class="bg-white dark:bg-black border-2 border-black dark:border-white shadow-3d p-8 rounded-none transition-colors duration-200">
            
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Email Entry -->
                <div>
                    <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-black dark:text-zinc-400 mb-2">Registered Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </span>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            value="{{ old('email', request('mock') ? request('mock') . '@proctored.com' : '') }}"
                            placeholder="you@example.com" 
                            class="block w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-slate-900 dark:text-white text-sm focus:outline-none focus:bg-white transition-colors">
                    </div>
                </div>

                <!-- Password Entry -->
                <div x-data="{ showPassword: false }">
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-black dark:text-zinc-400">Password</label>
                        <a href="#" class="text-xs font-bold text-black dark:text-white hover:underline">Forgot?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input 
                            id="password" 
                            name="password" 
                            :type="showPassword ? 'text' : 'password'" 
                            required 
                            value="{{ request('mock') ? 'password' : '' }}"
                            placeholder="••••••••••••" 
                            class="block w-full pl-10 pr-10 py-3.5 bg-slate-50 dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-slate-900 dark:text-white text-sm focus:outline-none focus:bg-white transition-colors">
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 dark:text-zinc-400 hover:text-black dark:hover:text-white transition-colors cursor-pointer"
                            title="Toggle password visibility">
                            <i class="fa-solid text-xs" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d flex items-center justify-center gap-2">
                    Verify Credentials
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">New to CodeManthan?</p>
                <a href="{{ route('register') }}" class="mt-1.5 inline-block text-xs font-black uppercase tracking-wider text-black dark:text-white hover:underline">
                    Create An Account
                </a>
            </div>

            <div class="relative my-6 text-center">
                <span class="absolute inset-x-0 top-1/2 border-t-2 border-black dark:border-zinc-850 pointer-events-none"></span>
                <span class="relative px-3 bg-white dark:bg-black text-[9px] font-black uppercase tracking-widest text-slate-400">Sandbox Hub</span>
            </div>

            <!-- Seeded Sandbox Direct Login Links -->
            <div class="space-y-3">
                <div class="text-center text-[9px] font-black text-slate-400 dark:text-zinc-550 uppercase tracking-widest mb-1">
                    Instant Demo logins
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <a href="{{ route('login.google-mock', 'candidate') }}" class="text-[9px] font-black uppercase tracking-wider px-2 py-3 border-2 border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white text-center transition-all duration-150 shadow-3d-stark">
                        <i class="fa-solid fa-user-graduate block mb-1"></i> Candidate
                    </a>
                    <a href="{{ route('login.google-mock', 'organizer') }}" class="text-[9px] font-black uppercase tracking-wider px-2 py-3 border-2 border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white text-center transition-all duration-150 shadow-3d-stark">
                        <i class="fa-solid fa-user-tie block mb-1"></i> Organizer
                    </a>
                    <a href="{{ route('login.google-mock', 'proctor') }}" class="text-[9px] font-black uppercase tracking-wider px-2 py-3 border-2 border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white text-center transition-all duration-150 shadow-3d-stark">
                        <i class="fa-solid fa-eye block mb-1"></i> Proctor
                    </a>
                </div>
            </div>

            <div class="relative my-6 text-center">
                <span class="absolute inset-x-0 top-1/2 border-t-2 border-black dark:border-zinc-850 pointer-events-none"></span>
                <span class="relative px-3 bg-white dark:bg-black text-[9px] font-black uppercase tracking-widest text-slate-400">Social Accounts</span>
            </div>

            <!-- Social accounts mockup -->
            <a href="{{ route('login.google-select') }}" class="w-full py-3.5 bg-slate-50 dark:bg-zinc-900 hover:bg-slate-100 dark:hover:bg-zinc-850 border-2 border-black dark:border-zinc-850 text-slate-800 dark:text-zinc-200 font-extrabold uppercase tracking-widest text-xs transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-5.136 4.114-3.54 0-6.423-2.884-6.423-6.423s2.884-6.422 6.423-6.422c1.613 0 3.08.6 4.225 1.583l3.056-3.056C19.263 2.14 15.976 1 12.24 1c-6.075 0-11 4.925-11 11s4.925 11 11 11c6.075 0 10.285-4.4 10.285-10.285 0-.585-.053-1.154-.153-1.714H12.24z"/>
                </svg>
                Sign In with Google Accounts
            </a>
        </div>
    </div>
</div>
@endsection
