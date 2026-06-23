@extends('layouts.app')

@section('title', 'CodeManthan - AI-Powered Secure Exam Platform')

@section('content')
<div class="relative overflow-hidden bg-monochrome-mesh bg-grid-stark min-h-[calc(100vh-4rem)] flex flex-col justify-center py-16 transition-colors duration-200">
    
    <!-- Decorative Floating 3D Elements -->
    <div class="hidden lg:block absolute top-24 left-12 w-20 h-20 border-2 border-black dark:border-white bg-slate-50/40 dark:bg-zinc-950/20 shadow-3d animate-float-slow opacity-25 pointer-events-none rounded-2xl"></div>
    <div class="hidden lg:block absolute bottom-28 right-16 w-28 h-28 border-2 border-black dark:border-white bg-slate-50/40 dark:bg-zinc-950/20 shadow-3d animate-float-slow opacity-25 pointer-events-none rounded-full" style="animation-delay: -4s;"></div>
    <div class="hidden lg:block absolute top-1/2 right-12 w-14 h-14 border-2 border-black dark:border-white bg-slate-50/40 dark:bg-zinc-950/20 shadow-3d animate-float-slow opacity-20 pointer-events-none rounded-xl" style="animation-delay: -2s;"></div>

    <!-- Hero Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16 relative z-10 text-center">
        <!-- Interactive Pill -->
        <div class="inline-flex items-center gap-2.5 px-4.5 py-2 border-2 border-black dark:border-white bg-white dark:bg-black text-xs font-black uppercase tracking-widest text-black dark:text-white mb-8 mx-auto shadow-3d-stark rounded-full">
            <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-ping shrink-0"></span>
            Proctored Screening Active
        </div>
 
        <!-- Stark Headline -->
        <h1 class="text-4xl sm:text-7xl font-black uppercase tracking-tight text-black dark:text-white leading-[1.0] mb-6">
            Conduct Secure Online Screening <br>
            With Absolute Integrity
        </h1>
 
        <!-- Subtext -->
        <p class="max-w-2xl mx-auto text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-zinc-400 mb-10 leading-relaxed">
            The platform designed for premium screening assessments. Enforce webcam proctoring, block tab switching, and run sandboxed code compilation fairly.
        </p>
 
        <!-- Dynamic Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-black dark:bg-white text-white dark:text-black font-extrabold uppercase tracking-widest text-xs btn-3d-pill text-center cursor-pointer">
                Get Started Free
            </a>
            <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-black text-black dark:text-white font-extrabold uppercase tracking-widest text-xs btn-3d-pill hover:bg-slate-50 dark:hover:bg-zinc-900 text-center cursor-pointer">
                Explore Features
            </a>
        </div>
 
        <!-- 3D Platform Mockup Presentation -->
        <div class="mt-16 max-w-4xl mx-auto border-4 border-black dark:border-white bg-white dark:bg-black shadow-3d p-6 relative isometric-3d rounded-2xl">
            <div class="absolute -top-3.5 -left-3.5 border-2 border-black dark:border-white bg-black dark:bg-white text-white dark:text-black px-3 py-1 text-[10px] font-extrabold uppercase tracking-widest rounded-lg shadow-md">
                CodeManthan Console Mock
            </div>

            <!-- Window Topbar Action Dots -->
            <div class="flex items-center gap-1.5 mb-4 pb-2 border-b border-black/10 dark:border-zinc-850">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500/80 border border-black/10"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500/80 border border-black/10"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/80 border border-black/10"></span>
            </div>
            
            <div class="grid grid-cols-3 gap-4 text-left">
                <div class="col-span-1 border-2 border-black dark:border-zinc-850 p-4 font-mono text-[9px] text-zinc-400 leading-normal rounded-xl bg-black text-white relative overflow-hidden crt-screen select-none">
                    <span class="block text-white font-black uppercase text-xs mb-3 flex items-center gap-1.5 shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span> AI Proctor</span>
                    [Webcam: Connected]<br>
                    [Surveillance: Active]<br>
                    [Proctor Risk: <span class="text-emerald-400 font-extrabold">0%</span>]
                </div>
                <div class="col-span-2 border-2 border-black dark:border-zinc-800 p-4 font-mono text-[9px] text-slate-450 leading-normal rounded-xl bg-slate-50/50 dark:bg-zinc-900/35">
                    <span class="block text-black dark:text-white font-black uppercase text-xs mb-3">Monaco Editor Sandbox</span>
                    <span class="text-emerald-600">def twoSum(nums, target):</span><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;hash_map = {}<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;for i, num in enumerate(nums):<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;diff = target - num<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if diff in hash_map:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-emerald-500 font-bold">return [hash_map[diff], i]</span>
                </div>
            </div>
        </div>
 
        <!-- Sandbox Access Quick Buttons (Terminal style) -->
        <div class="mt-14 max-w-xl mx-auto p-6 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d text-center rounded-2xl">
            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-black mb-4"><i class="fa-solid fa-terminal mr-1"></i>One-Click Sandbox Test Logins</p>
            <div class="grid grid-cols-3 gap-3">
                <a href="{{ route('login.google-mock', 'candidate') }}" class="text-[10px] font-black uppercase tracking-wider px-2 py-3.5 btn-3d-pill text-center bg-slate-50 dark:bg-zinc-900 cursor-pointer">
                    <i class="fa-solid fa-user-graduate block mb-1 text-sm"></i> Candidate
                </a>
                <a href="{{ route('login.google-mock', 'organizer') }}" class="text-[10px] font-black uppercase tracking-wider px-2 py-3.5 btn-3d-pill text-center bg-slate-50 dark:bg-zinc-900 cursor-pointer">
                    <i class="fa-solid fa-user-tie block mb-1 text-sm"></i> Organizer
                </a>
                <a href="{{ route('login.google-mock', 'proctor') }}" class="text-[10px] font-black uppercase tracking-wider px-2 py-3.5 btn-3d-pill text-center bg-slate-50 dark:bg-zinc-900 cursor-pointer">
                    <i class="fa-solid fa-eye block mb-1 text-sm"></i> Proctor
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Infinite Cyber-Proctor Events Marquee Ticker -->
<div class="border-y-2 border-black dark:border-zinc-800 bg-white dark:bg-black overflow-hidden py-3.5 select-none relative z-20">
    <div class="animate-marquee flex whitespace-nowrap gap-8 uppercase font-mono text-[9px] text-black dark:text-zinc-350 tracking-widest">
        <span class="flex items-center gap-1.5 shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span> AI PROCTOR: ACTIVE</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-camera mr-1"></i> WEBCAM AUDIT: STABLE (99.9% TRUST)</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-code mr-1"></i> MONACO SANDBOX COMPILER: ONLINE</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-lock mr-1"></i> SCREEN FOCUS BLUR EVENTS: ARMED</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-database mr-1"></i> MONGODB STATE METRICS: SYNCHRONIZED</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-shield-halved mr-1"></i> ISOLATION SECURITY LAYER: SECURED</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <!-- Repeated items for seamless scrolling loop -->
        <span class="flex items-center gap-1.5 shrink-0"><span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span> AI PROCTOR: ACTIVE</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-camera mr-1"></i> WEBCAM AUDIT: STABLE (99.9% TRUST)</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-code mr-1"></i> MONACO SANDBOX COMPILER: ONLINE</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-lock mr-1"></i> SCREEN FOCUS BLUR EVENTS: ARMED</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-database mr-1"></i> MONGODB STATE METRICS: SYNCHRONIZED</span>
        <span class="text-zinc-400 dark:text-zinc-700 font-bold shrink-0">//</span>
        <span class="shrink-0"><i class="fa-solid fa-shield-halved mr-1"></i> ISOLATION SECURITY LAYER: SECURED</span>
    </div>
</div>



<!-- Features Grid Section -->
<section id="features" class="py-24 bg-[#fafafa] dark:bg-black transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-xs font-black text-black dark:text-white uppercase tracking-widest mb-3">Auditing Capabilities</h2>
            <p class="text-2xl sm:text-4xl font-black uppercase text-black dark:text-white tracking-tight">
                Built to Prevent Exploits & Secure Algorithmic Assessments
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature Card 1 -->
            <div class="p-8 bg-white dark:bg-black card-3d-dynamic flex flex-col items-start gap-5">
                <div class="w-12 h-12 border-2 border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center rounded-lg">
                    <i class="fa-solid fa-video text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-black uppercase text-black dark:text-white mb-2">Camera Snapshot Audits</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                        Logs periodic visual feeds, flags missing candidates, and logs tab switches dynamically in MongoDB.
                    </p>
                </div>
            </div>

            <!-- Feature Card 2 -->
            <div class="p-8 bg-white dark:bg-black card-3d-dynamic flex flex-col items-start gap-5">
                <div class="w-12 h-12 border-2 border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center rounded-lg">
                    <i class="fa-solid fa-code text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-black uppercase text-black dark:text-white mb-2">Monaco Code Sandboxes</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                        Execute functions in Python, JS, and PHP. Run code directly against functional test sets instantly.
                    </p>
                </div>
            </div>

            <!-- Feature Card 3 -->
            <div class="p-8 bg-white dark:bg-black card-3d-dynamic flex flex-col items-start gap-5">
                <div class="w-12 h-12 border-2 border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center rounded-lg">
                    <i class="fa-solid fa-lock text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-black uppercase text-black dark:text-white mb-2">Structural Security Locks</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                        Blocks clipboard context menu right-clicks, disables copy-paste hooks, and locks browser fullscreens.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-24 bg-white dark:bg-black border-t-2 border-black dark:border-zinc-800 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-xs font-black text-black dark:text-white uppercase tracking-widest mb-3">Workflow Pipeline</h2>
            <p class="text-2xl sm:text-4xl font-black uppercase text-black dark:text-white tracking-tight">
                How CodeManthan Protects Exams
            </p>
        </div>

        <!-- 3-Step Grid -->
        <div class="grid md:grid-cols-3 gap-8 relative">
            
            <!-- Step 1 -->
            <div class="p-8 bg-[#fafafa] dark:bg-zinc-950/40 border-2 border-black dark:border-zinc-850 rounded-2xl shadow-3d relative flex flex-col justify-between h-72 hover:-translate-y-1 transition-all duration-200">
                <div>
                    <div class="w-10 h-10 border-2 border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-black text-sm tracking-wider rounded-lg mb-6">
                        01
                    </div>
                    <h3 class="text-base font-black uppercase text-black dark:text-white mb-2">Configure Assessments</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                        Organizers build exams, input aptitude questions, and inject coding tasks with starter templates and dynamic hidden test cases.
                    </p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="p-8 bg-[#fafafa] dark:bg-zinc-950/40 border-2 border-black dark:border-zinc-850 rounded-2xl shadow-3d relative flex flex-col justify-between h-72 hover:-translate-y-1 transition-all duration-200">
                <div>
                    <div class="w-10 h-10 border-2 border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-black text-sm tracking-wider rounded-lg mb-6">
                        02
                    </div>
                    <h3 class="text-base font-black uppercase text-black dark:text-white mb-2">Device Diagnostic Lobby</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                        Candidates audit hardware camera connections, accept tracking regulations, and enter the secure, locked exam hall.
                    </p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="p-8 bg-[#fafafa] dark:bg-zinc-950/40 border-2 border-black dark:border-zinc-850 rounded-2xl shadow-3d relative flex flex-col justify-between h-72 hover:-translate-y-1 transition-all duration-200">
                <div>
                    <div class="w-10 h-10 border-2 border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-black text-sm tracking-wider rounded-lg mb-6">
                        03
                    </div>
                    <h3 class="text-base font-black uppercase text-black dark:text-white mb-2">Automated Audit & Grading</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                        Real-time AI tracks window compliance, autosaves snapshots progressively, evaluates sandboxed scripts, and generates reports.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Interactive Audit Simulator Section -->
<section class="py-24 bg-[#fafafa] dark:bg-black border-t-2 border-black dark:border-zinc-800 transition-colors duration-200" x-data="{
    running: false,
    integrity: 100,
    logs: [],
    step: 0,
    simulationSteps: [
        { time: '09:00:02', msg: 'Session initialized. Sandbox environment secured.', risk: 0 },
        { time: '09:00:15', msg: 'Webcam feed authorized. AI face tracking calibrated.', risk: 0 },
        { time: '09:01:45', msg: 'Candidate loaded Coding Task: LeetCode TwoSum.', risk: 0 },
        { time: '09:03:12', msg: 'WARNING: Fullscreen mode exited! Blur event logged.', risk: 25 },
        { time: '09:03:15', msg: 'Proctor Alert: Dispatching browser blur warning to lobby.', risk: 25 },
        { time: '09:05:22', msg: 'Autosave snapshot synced with local MongoDB cluster.', risk: 25 },
        { time: '09:07:40', msg: 'ALERT: Webcam face tracking lost! Empty frame flagged.', risk: 65 },
        { time: '09:07:45', msg: 'Live Proctor notified. Integrity risk seal updated to SUSPECT.', risk: 65 },
        { time: '09:09:12', msg: 'Candidate re-entered console. Code compiled successfully (3/3 passed).', risk: 65 },
        { time: '09:09:30', msg: 'Screening sheet committed. Finalizing AI audit review.', risk: 65 }
    ],
    runSimulation() {
        if (this.running) return;
        this.running = true;
        this.integrity = 100;
        this.logs = [];
        this.step = 0;
        this.addLogStep();
    },
    addLogStep() {
        if (this.step < this.simulationSteps.length) {
            let next = this.simulationSteps[this.step];
            this.logs.push(next);
            this.integrity = 100 - next.risk;
            this.step++;
            
            // Auto scroll terminal
            setTimeout(() => {
                let term = this.$refs.terminal;
                if (term) term.scrollTop = term.scrollHeight;
            }, 50);

            setTimeout(() => this.addLogStep(), 1200);
        } else {
            this.running = false;
        }
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-xs font-black text-black dark:text-white uppercase tracking-widest mb-3">Integrity Simulation</h2>
            <p class="text-2xl sm:text-4xl font-black uppercase text-black dark:text-white tracking-tight">
                Experience Real-Time AI Proctoring
            </p>
        </div>

        <div class="grid lg:grid-cols-5 gap-8 items-center">
            
            <!-- Monospace Terminal & Live AI Camera split panel (3/5 Width) -->
            <div class="lg:col-span-3 border-4 border-black dark:border-white bg-black rounded-2xl shadow-3d relative overflow-hidden h-80 grid grid-cols-1 md:grid-cols-5">
                
                <!-- Terminal Logs (3/5 Width inside the panel) -->
                <div class="md:col-span-3 p-6 flex flex-col justify-between h-full relative crt-screen">
                    <!-- Top dots -->
                    <div class="flex items-center gap-1.5 pb-2 border-b border-zinc-800">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500/80"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500/80"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/80"></span>
                        <span class="text-[9px] font-mono text-zinc-500 uppercase ml-2 tracking-widest">LIVE SESSION SIMULATOR</span>
                    </div>

                    <!-- Term logs -->
                    <div x-ref="terminal" class="flex-grow overflow-y-auto font-mono text-[9px] text-zinc-300 space-y-2 mt-4 pr-2 scrollbar-thin select-none">
                        <div class="text-zinc-550">// Press 'Initiate Audit' to watch the proctor check active sessions...</div>
                        <template x-for="log in logs">
                            <div class="flex items-start gap-2 leading-relaxed">
                                <span class="text-zinc-500" x-text="log.time"></span>
                                <span :class="log.risk > 40 ? 'text-rose-500 font-bold' : (log.risk > 0 ? 'text-amber-500 font-bold' : 'text-emerald-400')" x-text="log.msg"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Live AI Camera Simulator Feed (2/5 Width inside the panel) -->
                <div class="md:col-span-2 border-t md:border-t-0 md:border-l border-zinc-850 bg-zinc-950 p-4 flex flex-col justify-between items-center relative overflow-hidden select-none crt-screen">
                    <!-- Camera Overlay Labels -->
                    <div class="w-full flex justify-between items-center text-[7px] font-mono tracking-widest text-zinc-550 z-10">
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span> REC
                        </span>
                        <span>CAM_01_PROCTOR</span>
                    </div>

                    <!-- Silhouette and Face Tracking Box -->
                    <div class="relative w-full flex-grow flex items-center justify-center py-2 z-10">
                        <!-- Face Tracking Bounding Box -->
                        <div class="absolute border-2 transition-all duration-300 flex flex-col justify-between p-1 rounded"
                             :class="integrity < 40 ? 'border-rose-600 w-24 h-24' : (integrity < 80 ? 'border-amber-500 w-24 h-24' : (running ? 'border-emerald-500 w-20 h-20' : 'border-zinc-850 w-20 h-20'))">
                            
                            <!-- Corners for Brutalist look -->
                            <span class="absolute top-0 left-0 w-2 h-2 border-t-2 border-l-2" :class="integrity < 40 ? 'border-rose-600' : (integrity < 80 ? 'border-amber-500' : 'border-emerald-500')"></span>
                            <span class="absolute top-0 right-0 w-2 h-2 border-t-2 border-r-2" :class="integrity < 40 ? 'border-rose-600' : (integrity < 80 ? 'border-amber-500' : 'border-emerald-500')"></span>
                            <span class="absolute bottom-0 left-0 w-2 h-2 border-b-2 border-l-2" :class="integrity < 40 ? 'border-rose-600' : (integrity < 80 ? 'border-amber-500' : 'border-emerald-500')"></span>
                            <span class="absolute bottom-0 right-0 w-2 h-2 border-b-2 border-r-2" :class="integrity < 40 ? 'border-rose-600' : (integrity < 80 ? 'border-amber-500' : 'border-emerald-500')"></span>

                            <!-- AI stats in bounding box -->
                            <div class="w-full flex justify-between text-[6px] font-mono uppercase tracking-tighter" :class="integrity < 40 ? 'text-rose-600' : (integrity < 80 ? 'text-amber-500' : 'text-emerald-500')">
                                <span>AI_FOCUS</span>
                                <span x-text="running ? integrity + '%' : 'N/A'"></span>
                            </div>
                            <div class="w-full text-center text-[7px] font-bold font-mono tracking-widest uppercase" :class="integrity < 40 ? 'text-rose-600' : (integrity < 80 ? 'text-amber-500' : 'text-emerald-500')">
                                <span x-text="integrity < 40 ? 'VACANT' : (integrity < 80 ? 'BLUR' : (running ? 'ACTIVE' : 'READY'))"></span>
                            </div>
                        </div>

                        <!-- Candidate Vector Silhouette SVG -->
                        <svg class="w-16 h-16 transition-all duration-300"
                             :class="integrity < 40 ? 'opacity-0' : (integrity < 80 ? 'opacity-70 text-amber-550' : (running ? 'opacity-100 text-zinc-300' : 'opacity-40 text-zinc-650'))"
                             viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>

                        <!-- Dynamic Static/Noise Scanline when Vacant (Integrity low) -->
                        <div x-show="integrity < 40 && running" class="absolute inset-0 bg-zinc-950 flex flex-col items-center justify-center p-4 text-center z-20">
                            <span class="text-rose-650 font-black font-mono text-[9px] uppercase tracking-widest animate-pulse"><i class="fa-solid fa-triangle-exclamation mr-1"></i> FEED DISRUPTED</span>
                            <span class="text-rose-700 font-mono text-[7px] mt-1 uppercase tracking-widest font-extrabold">VACANT SEAT DETECTED</span>
                        </div>
                    </div>

                    <!-- AI Diagnostics Info -->
                    <div class="w-full font-mono text-[7px] text-zinc-500 flex justify-between items-center border-t border-zinc-900 pt-2 z-10">
                        <span>PROCTOR_AI_V2</span>
                        <span :class="integrity < 40 ? 'text-rose-600 font-bold' : (integrity < 80 ? 'text-amber-500' : (running ? 'text-emerald-500' : 'text-zinc-650'))"
                              x-text="integrity < 40 ? 'CRITICAL ALERT' : (integrity < 80 ? 'TAB OUT LOGGED' : (running ? 'STATUS: NOMINAL' : 'STATUS: IDLE'))"></span>
                    </div>

                    <!-- Scanning line overlay -->
                    <div class="absolute inset-x-0 h-[1px] bg-emerald-500/20 top-0 pointer-events-none"
                         :class="running ? (integrity < 40 ? 'bg-rose-500/25 animate-sweep-fast' : 'animate-sweep') : 'hidden'"></div>
                </div>
            </div>

            <!-- Controls (2/5 Width) -->
            <div class="lg:col-span-2 p-8 bg-white dark:bg-black border-2 border-black dark:border-white rounded-2xl shadow-3d flex flex-col justify-between h-80">
                <div>
                    <h3 class="text-lg font-black uppercase text-black dark:text-white mb-2">Simulate Proctor Logs</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider mb-6">
                        Watch how the dynamic AI algorithms audit face-tracking lost frames, tab blur locks, and update security metrics in real time.
                    </p>
                </div>

                <div class="space-y-6">
                    <!-- Progress meter -->
                    <div class="flex justify-between items-center bg-slate-50 dark:bg-zinc-900/50 p-4 border border-black/35 rounded-xl">
                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Integrity Seal</span>
                            <span class="text-lg font-extrabold uppercase mt-0.5 block tracking-wider" :class="integrity < 40 ? 'text-rose-600' : (integrity < 80 ? 'text-amber-500' : 'text-emerald-500')">
                                <span x-text="integrity"></span>% Trust
                            </span>
                        </div>
                        <div class="w-10 h-10 border border-black/20 rounded-full flex items-center justify-center font-black text-xs font-mono bg-white dark:bg-black" :class="integrity < 40 ? 'text-rose-600 border-rose-500' : (integrity < 80 ? 'text-amber-500 border-amber-500' : 'text-emerald-500 border-emerald-500')">
                            <i class="fa-solid" :class="integrity < 40 ? 'fa-triangle-exclamation' : (integrity < 80 ? 'fa-eye' : 'fa-circle-check')"></i>
                        </div>
                    </div>

                    <!-- Trigger -->
                    <button 
                        type="button" 
                        @click="runSimulation()"
                        :disabled="running"
                        class="w-full py-4 text-xs font-extrabold uppercase tracking-widest btn-3d-pill bg-black dark:bg-white text-white dark:text-black cursor-pointer flex items-center justify-center gap-2"
                        :class="running ? 'opacity-50 cursor-not-allowed' : ''">
                        <i class="fa-solid fa-play text-[10px]" :class="running ? 'fa-spinner animate-spin' : ''"></i>
                        Initiate Audit Simulation
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- FAQ Section with Alpine.js -->
<section class="py-24 bg-white dark:bg-black border-t-2 border-black dark:border-zinc-800 transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-xs font-black text-black dark:text-white uppercase tracking-widest mb-3">Auditor Queries</h2>
            <p class="text-2xl font-black uppercase text-black dark:text-white">Frequently Asked Questions</p>
        </div>

        <div class="space-y-4" x-data="{ activeFaq: null }">
            <!-- FAQ Item 1 -->
            <div class="bg-white dark:bg-black card-3d-dynamic p-6">
                <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full flex justify-between items-center text-left cursor-pointer">
                    <span class="font-extrabold text-xs uppercase tracking-wider text-black dark:text-white">What if the browser lacks a webcam plugged in?</span>
                    <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200 text-slate-400" :class="activeFaq === 1 ? 'rotate-180 text-black dark:text-white' : ''"></i>
                </button>
                <div x-show="activeFaq === 1" x-transition.opacity class="mt-4 text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                    Our platform incorporates a **Webcam Diagnostics Fail-Safe**. If no camera is detected or access is restricted locally (due to unencrypted HTTP browser rules), the portal activates a **"CodeManthan Virtual Camera Feed"** fallback, allowing full dashboard testing on any developer workspace.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white dark:bg-black card-3d-dynamic p-6">
                <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full flex justify-between items-center text-left cursor-pointer">
                    <span class="font-extrabold text-xs uppercase tracking-wider text-black dark:text-white">How does the AI Cheating Score algorithm operate?</span>
                    <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200 text-slate-400" :class="activeFaq === 2 ? 'rotate-180 text-black dark:text-white' : ''"></i>
                </button>
                <div x-show="activeFaq === 2" x-transition.opacity class="mt-4 text-xs font-semibold text-slate-500 dark:text-zinc-400 leading-relaxed uppercase tracking-wider">
                    The backend continuously audits logged events (tab blurs, fullscreen exit). It aggregates violation metrics mapped directly into dynamic suspicion percentages (0-100%), allowing proctors to warn suspect candidate consoles live.
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
