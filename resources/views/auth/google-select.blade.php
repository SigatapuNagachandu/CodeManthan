@extends('layouts.app')

@section('title', 'Select Account - CodeManthan Security Hub')

@section('content')
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center bg-monochrome-mesh py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        
        <!-- Platform Branding Header -->
        <div class="text-center">
            <svg class="w-10 h-10 mx-auto mb-4 border-2 border-black p-1 bg-white" viewBox="0 0 24 24">
                <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-5.136 4.114-3.54 0-6.423-2.884-6.423-6.423s2.884-6.422 6.423-6.422c1.613 0 3.08.6 4.225 1.583l3.056-3.056C19.263 2.14 15.976 1 12.24 1c-6.075 0-11 4.925-11 11s4.925 11 11 11c6.075 0 10.285-4.4 10.285-10.285 0-.585-.053-1.154-.153-1.714H12.24z"/>
            </svg>
            <h2 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white">
                Choose an Account
            </h2>
            <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550">
                CodeManthan sandboxed multi-identity demo lobby
            </p>
        </div>

        <!-- Account Chooser Card -->
        <div class="bg-white dark:bg-black border-2 border-black dark:border-white shadow-3d p-8 rounded-none transition-colors duration-200" x-data="{ customActive: false }">
            
            <div class="space-y-4">
                <div class="text-[9px] font-black text-slate-400 dark:text-zinc-550 uppercase tracking-widest mb-1">
                    Select Seeded Account
                </div>
                
                <!-- Profile 1: Alex Rivera (Candidate) -->
                <a href="{{ route('login.google-mock', 'candidate') }}" class="flex items-center justify-between p-3.5 border-2 border-black dark:border-zinc-800 hover:bg-slate-50 dark:hover:bg-zinc-900 transition-all shadow-3d-stark">
                    <div class="flex items-center gap-3">
                        <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Alex" class="w-8 h-8 rounded-full border border-black bg-slate-50 shrink-0" alt="Avatar">
                        <div class="text-left">
                            <span class="block text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white">Alex Rivera</span>
                            <span class="block text-[10px] text-slate-400 font-mono leading-none mt-0.5">candidate@proctored.com</span>
                        </div>
                    </div>
                    <span class="text-[8px] font-black px-1.5 py-0.5 border border-black bg-black text-white dark:bg-white dark:text-black uppercase">Candidate</span>
                </a>

                <!-- Profile 2: Dr. Sophia Carter (Organizer) -->
                <a href="{{ route('login.google-mock', 'organizer') }}" class="flex items-center justify-between p-3.5 border-2 border-black dark:border-zinc-800 hover:bg-slate-50 dark:hover:bg-zinc-900 transition-all shadow-3d-stark">
                    <div class="flex items-center gap-3">
                        <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Sophia" class="w-8 h-8 rounded-full border border-black bg-slate-50 shrink-0" alt="Avatar">
                        <div class="text-left">
                            <span class="block text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white">Dr. Sophia Carter</span>
                            <span class="block text-[10px] text-slate-400 font-mono leading-none mt-0.5">organizer@proctored.com</span>
                        </div>
                    </div>
                    <span class="text-[8px] font-black px-1.5 py-0.5 border border-black bg-black text-white dark:bg-white dark:text-black uppercase">Organizer</span>
                </a>

                <!-- Profile 3: Proctor Agent Alpha (Proctor) -->
                <a href="{{ route('login.google-mock', 'proctor') }}" class="flex items-center justify-between p-3.5 border-2 border-black dark:border-zinc-800 hover:bg-slate-50 dark:hover:bg-zinc-900 transition-all shadow-3d-stark">
                    <div class="flex items-center gap-3">
                        <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Proctor" class="w-8 h-8 rounded-full border border-black bg-slate-50 shrink-0" alt="Avatar">
                        <div class="text-left">
                            <span class="block text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white">Proctor Agent Alpha</span>
                            <span class="block text-[10px] text-slate-400 font-mono leading-none mt-0.5">proctor@proctored.com</span>
                        </div>
                    </div>
                    <span class="text-[8px] font-black px-1.5 py-0.5 border border-black bg-black text-white dark:bg-white dark:text-black uppercase">Proctor</span>
                </a>
            </div>

            <div class="relative my-6 text-center">
                <span class="absolute inset-x-0 top-1/2 border-t-2 border-black dark:border-zinc-850 pointer-events-none"></span>
                <span class="relative px-3 bg-white dark:bg-black text-[9px] font-black uppercase tracking-widest text-slate-400">OAuth custom simulator</span>
            </div>

            <!-- Custom User Google Login Panel -->
            <div class="space-y-4">
                <button 
                    @click="customActive = !customActive" 
                    class="w-full py-3.5 border-2 border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white font-extrabold uppercase tracking-widest text-xs transition-all shadow-3d-stark flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    Use A Custom Google Account
                </button>

                <!-- Input form for custom google signin -->
                <form 
                    x-show="customActive" 
                    x-transition.opacity 
                    action="{{ route('login.google-mock', 'candidate') }}" 
                    method="GET"
                    class="space-y-4 pt-4 border-t-2 border-dashed border-black/10 dark:border-zinc-800">
                    
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Custom Account Name</label>
                        <input type="text" name="name" required class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-850 rounded-none text-xs" placeholder="e.g. Liam Neeson">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Custom Account Email</label>
                        <input type="email" name="email" required class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-850 rounded-none text-xs" placeholder="e.g. liam.neeson@gmail.com">
                    </div>

                    <button type="submit" class="w-full py-3 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-[10px] transition-all shadow-3d">
                        Link & Connect Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
