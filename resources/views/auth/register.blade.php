@extends('layouts.app')

@section('title', 'Create Account - CodeManthan Security Hub')

@section('content')
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center bg-monochrome-mesh py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        
        <!-- Platform Branding Header -->
        <div class="text-center">
            <div class="w-12 h-12 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white flex items-center justify-center font-black text-lg mx-auto mb-4">
                R
            </div>
            <h2 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white">
                Create Account
            </h2>
            <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550">
                Join CodeManthan to sit screening assessments
            </p>
        </div>

        <!-- Glassmorphism Form Card -->
        <div class="bg-white dark:bg-black border-2 border-black dark:border-white shadow-3d p-8 rounded-none transition-colors duration-200">
            
            <form class="space-y-4" action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Full Name Entry -->
                <div>
                    <label for="name" class="block text-[10px] font-black uppercase tracking-widest text-black dark:text-zinc-400 mb-1.5">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-regular fa-user text-sm"></i>
                        </span>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            required 
                            placeholder="John Doe" 
                            class="block w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-slate-900 dark:text-white text-sm focus:outline-none focus:bg-white transition-colors">
                    </div>
                </div>

                <!-- Email Entry -->
                <div>
                    <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-black dark:text-zinc-400 mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </span>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            placeholder="you@example.com" 
                            class="block w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-slate-900 dark:text-white text-sm focus:outline-none focus:bg-white transition-colors">
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-[10px] font-black uppercase tracking-widest text-black dark:text-zinc-400 mb-1.5">Select Role</label>
                    <select 
                        id="role" 
                        name="role" 
                        required 
                        class="block w-full p-3 bg-slate-50 dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-slate-900 dark:text-white text-sm focus:outline-none focus:bg-white transition-colors">
                        <option value="candidate" selected>Candidate (Participate in screenings)</option>
                        <option value="organizer">Organizer (Conduct screenings & monitor exams)</option>
                    </select>
                </div>

                <!-- Password Entry -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-black dark:text-zinc-400 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input 
                            id="password" 
                            name="password" 
                            :type="showPassword ? 'text' : 'password'" 
                            required 
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
                <button type="submit" class="w-full py-4 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d flex items-center justify-center gap-2 mt-4">
                    Register & Generate OTP
                    <i class="fa-solid fa-user-plus text-xs"></i>
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Already have an account?</p>
                <a href="{{ route('login') }}" class="mt-1.5 inline-block text-xs font-black uppercase tracking-wider text-black dark:text-white hover:underline">
                    Sign In
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
