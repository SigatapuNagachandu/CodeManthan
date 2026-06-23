<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CodeManthan Platform')</title>
    <meta name="description" content="AI-Powered Secure Screening and Algorithmic Exam Platform.">

    <!-- Montserrat/Outfit/Inter Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind Play CDN for immediate visual rendering & fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f4f4f5',
                            100: '#e4e4e7',
                            200: '#d4d4d8',
                            500: '#18181b',
                            600: '#09090b',
                            700: '#000000',
                        },
                        dark: {
                            surface: '#000000',
                            card: '#0b0b0d',
                            border: '#18181b'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS Styles -->
    @vite(['resources/css/app.css'])

    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Stark design style overrides -->
    <style>
        .stark-nav {
            background-color: #ffffff;
            border-bottom: 2px solid #09090b;
        }
        .dark .stark-nav {
            background-color: #000000;
            border-bottom: 2px solid #f4f4f5;
        }
        .shadow-3d-stark {
            box-shadow: 4px 4px 0px 0px #09090b;
            border: 2px solid #09090b;
        }
        .dark .shadow-3d-stark {
            box-shadow: 4px 4px 0px 0px #f4f4f5;
            border: 2px solid #f4f4f5;
        }
        .tilt-3d-stark {
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .tilt-3d-stark:hover {
            transform: translate(-3px, -3px);
            box-shadow: 7px 7px 0px 0px #09090b;
        }
        .dark .tilt-3d-stark:hover {
            box-shadow: 7px 7px 0px 0px #f4f4f5;
        }
        .tilt-3d-stark:active {
            transform: translate(1px, 1px);
            box-shadow: 3px 3px 0px 0px #09090b;
        }
        .dark .tilt-3d-stark:active {
            box-shadow: 3px 3px 0px 0px #f4f4f5;
        }
    </style>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-900 bg-[#fafafa] dark:bg-black dark:text-zinc-200 transition-colors duration-200 min-h-screen flex flex-col" x-data="{ darkMode: localStorage.getItem('color-theme') === 'dark' }">

    <!-- Header Navigation -->
    <nav class="stark-nav sticky top-0 z-40 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Platform Brand Logo -->
                <div class="flex items-center">
                    @if(Route::is('landing'))
                        <!-- Dynamic Rotating Logo (Only on Landing Page) -->
                        <a href="{{ route('landing') }}" class="flex items-center gap-2 group select-none animate-pulse-slow" x-data="{
                            languages: ['Manthan', 'मंथन', 'மந்தன்', 'మథనం', 'মন্থন'],
                            index: 0,
                            visible: true,
                            init() {
                                setInterval(() => {
                                    this.visible = false;
                                    setTimeout(() => {
                                        this.index = (this.index + 1) % this.languages.length;
                                        this.visible = true;
                                    }, 250);
                                }, 3000);
                            }
                        }">
                            <div class="w-8 h-8 bg-black dark:bg-white text-white dark:text-black border border-black dark:border-white flex items-center justify-center font-extrabold text-sm tracking-tighter rounded-lg transition-all duration-500 group-hover:rotate-[360deg] shadow-sm">
                                C
                            </div>
                            <span class="font-extrabold text-lg tracking-wider uppercase text-black dark:text-white flex items-center gap-1">
                                <span>Code</span><span class="font-light border-b-2 border-black dark:border-white pb-0.5 inline-block text-center transition-all duration-200 transform" :class="visible ? 'opacity-100 scale-100' : 'opacity-0 scale-95'" x-text="languages[index]">Manthan</span>
                            </span>
                        </a>
                    @else
                        <!-- Static Logo (On other pages) -->
                        <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 bg-black dark:bg-white text-white dark:text-black border border-black dark:border-white flex items-center justify-center font-extrabold text-sm tracking-tighter">
                                C
                            </div>
                            <span class="font-extrabold text-lg tracking-wider uppercase text-black dark:text-white">
                                Code<span class="font-light">Manthan</span>
                            </span>
                        </a>
                    @endif
                </div>

                <!-- Navigation Elements -->
                <div class="flex items-center gap-3">
                    <!-- Light/Dark Mode Switcher -->
                    <button 
                        @click="
                            darkMode = !darkMode; 
                            localStorage.setItem('color-theme', darkMode ? 'dark' : 'light');
                            if(darkMode) { document.documentElement.classList.add('dark'); } 
                            else { document.documentElement.classList.remove('dark'); }
                        "
                        class="p-2 border border-transparent hover:border-black dark:hover:border-white text-slate-700 dark:text-zinc-300 transition-colors duration-150"
                        title="Toggle Visual Mode">
                        <i :class="darkMode ? 'fa-solid fa-sun text-yellow-400 text-base' : 'fa-solid fa-moon text-base'"></i>
                    </button>

                    @auth
                        <!-- Dashboard Redirect Links -->
                        <div class="hidden md:flex items-center gap-3">
                            @if(Auth::user()->isOrganizer() || Auth::user()->isSuperAdmin())
                                <a href="{{ route('organizer.dashboard') }}" class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-zinc-300 hover:text-black dark:hover:text-white">Dashboard</a>
                            @elseif(Auth::user()->isCandidate())
                                <a href="{{ route('candidate.dashboard') }}" class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-zinc-300 hover:text-black dark:hover:text-white">My Exams</a>
                            @elseif(Auth::user()->isProctor())
                                <a href="{{ route('proctor.dashboard') }}" class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-zinc-300 hover:text-black dark:hover:text-white">Monitoring</a>
                            @endif
                        </div>

                        <!-- Logged In User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 border border-black dark:border-white text-black dark:text-white font-bold text-xs uppercase tracking-wider">
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </button>

                            <!-- Dropdown List -->
                            <div 
                                x-show="open" 
                                @click.away="open = false"
                                x-transition.opacity
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-black border-2 border-black dark:border-white shadow-xl py-2 z-50">
                                
                                <div class="px-4 py-2 border-b border-black dark:border-zinc-800">
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Signed in as</p>
                                    <p class="text-xs font-extrabold text-black dark:text-white truncate mt-0.5">{{ Auth::user()->email }}</p>
                                    <span class="inline-block mt-1 text-[8px] font-bold px-1 py-0.5 bg-black dark:bg-white text-white dark:text-black uppercase">
                                        {{ str_replace('_', ' ', Auth::user()->role) }}
                                    </span>
                                </div>

                                @if(Auth::user()->isOrganizer() || Auth::user()->isSuperAdmin())
                                    <a href="{{ route('organizer.dashboard') }}" class="block px-4 py-2 text-xs font-bold text-slate-600 dark:text-zinc-300 hover:bg-slate-50 dark:hover:bg-zinc-900 hover:text-black dark:hover:text-white"><i class="fa-solid fa-chart-line mr-2"></i>Dashboard</a>
                                @elseif(Auth::user()->isCandidate())
                                    <a href="{{ route('candidate.dashboard') }}" class="block px-4 py-2 text-xs font-bold text-slate-600 dark:text-zinc-300 hover:bg-slate-50 dark:hover:bg-zinc-900 hover:text-black dark:hover:text-white"><i class="fa-solid fa-graduation-cap mr-2"></i>My Exams</a>
                                @elseif(Auth::user()->isProctor())
                                    <a href="{{ route('proctor.dashboard') }}" class="block px-4 py-2 text-xs font-bold text-slate-600 dark:text-zinc-300 hover:bg-slate-50 dark:hover:bg-zinc-900 hover:text-black dark:hover:text-white"><i class="fa-solid fa-eye mr-2"></i>Live Monitor</a>
                                @endif

                                <hr class="my-1 border-black dark:border-zinc-800">
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/20">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Auth buttons -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-xs font-extrabold uppercase tracking-wider text-slate-700 dark:text-zinc-300 hover:text-black dark:hover:text-white px-3 py-2">Sign In</a>
                            <a href="{{ route('login') }}?mock=candidate" class="inline-flex items-center text-xs font-extrabold uppercase tracking-wider text-white dark:text-black bg-black dark:bg-white border-2 border-black dark:border-white px-4 py-2 shadow-sm tilt-3d-stark">
                                Candidate Demo
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Toast Success/Warning alerts overlay -->
    @if(session('success') || session('error') || session('info') || $errors->any())
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 7000)"
            x-transition.opacity
            class="fixed bottom-6 right-6 z-50 max-w-sm w-full p-4 shadow-2xl border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d-stark"
            :class="{
                'bg-emerald-50 dark:bg-emerald-950/10': {{ session('success') ? 'true' : 'false' }},
                'bg-rose-50 dark:bg-rose-950/10': {{ session('error') || $errors->any() ? 'true' : 'false' }},
                'bg-slate-50 dark:bg-zinc-900': {{ session('info') ? 'true' : 'false' }},
            }">
            
            <div class="flex items-start gap-3">
                @if(session('success'))
                    <div class="w-7 h-7 bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0 border border-black dark:border-white">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-black dark:text-white">Operation Success</h4>
                        <p class="text-xs text-slate-550 dark:text-zinc-400 mt-0.5">{{ session('success') }}</p>
                    </div>
                @elseif(session('error') || $errors->any())
                    <div class="w-7 h-7 bg-red-650 text-white flex items-center justify-center shrink-0 border border-black">
                        <i class="fa-solid fa-exclamation text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-black dark:text-white">Action Denied</h4>
                        <p class="text-xs text-slate-550 dark:text-zinc-400 mt-0.5">
                            {{ session('error') ?: $errors->first() }}
                        </p>
                    </div>
                @elseif(session('info'))
                    <div class="w-7 h-7 bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0 border border-black dark:border-white">
                        <i class="fa-solid fa-info text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-black dark:text-white">Notice</h4>
                        <p class="text-xs text-slate-550 dark:text-zinc-400 mt-0.5">{{ session('info') }}</p>
                    </div>
                @endif
                <button @click="show = false" class="text-slate-400 hover:text-black dark:hover:text-white transition-colors shrink-0">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Footer Area -->
    <footer class="border-t-2 border-black dark:border-zinc-800 py-8 bg-white dark:bg-black text-center text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-650 transition-colors">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} CodeManthan screening platform. engineered for absolute transparency.</p>
            <div class="flex justify-center gap-6 mt-3 text-[9px]">
                <a href="#" class="hover:text-black dark:hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-black dark:hover:text-white transition-colors">GDPR Webcam Policy</a>
                <a href="#" class="hover:text-black dark:hover:text-white transition-colors">Security Architecture</a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
