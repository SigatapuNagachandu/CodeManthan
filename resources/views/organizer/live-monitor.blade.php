@extends('layouts.app')

@section('title', 'Live Exam Monitor - CodeManthan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ warningModal: false, warningCandidateId: '', warningCandidateName: '', warningMessage: '' }">
    
    <!-- Navigation Breadcrumbs -->
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase mb-4">
        <a href="{{ route('organizer.dashboard') }}" class="hover:text-black dark:hover:text-white">Organizer Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
        <span>Live Proctor Center</span>
    </div>

    <!-- Live Header with Heartbeat Ping -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-6 border-b-2 border-black dark:border-zinc-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-rose-600 pulse-glow-red shrink-0 border border-black"></span>
                <span class="text-xs font-black text-rose-650 dark:text-rose-400 uppercase tracking-widest">Active Live Monitoring Feed</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase text-slate-900 dark:text-white tracking-tight mt-1">{{ $exam->title }}</h1>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550 mt-1">Monitor live candidate screens, audit cameras, and issue warnings.</p>
        </div>
        <a href="{{ route('organizer.dashboard') }}" class="px-4 py-2.5 border-2 border-black dark:border-zinc-800 text-slate-750 dark:text-zinc-300 font-extrabold text-xs uppercase hover:bg-slate-50 transition-colors shadow-3d-stark">
            <i class="fa-solid fa-arrow-left-long mr-2"></i>Return Console
        </a>
    </div>

    <!-- Candidate Monitoring Grid -->
    @if($submissions->isEmpty())
        <div class="p-16 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d text-center">
            <div class="w-12 h-12 border border-black dark:border-white bg-slate-50 dark:bg-zinc-800 flex items-center justify-center text-slate-400 mx-auto mb-4 animate-bounce">
                <i class="fa-solid fa-satellite-dish text-lg"></i>
            </div>
            <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white">Waiting for Candidates...</h3>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550 mt-1 max-w-sm mx-auto">No candidate exam sessions are currently active.</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($submissions as $sub)
                <div class="p-6 border-2 border-black dark:border-zinc-850 bg-white dark:bg-zinc-900 shadow-3d flex flex-col justify-between min-h-[350px]">
                    
                    <!-- Candidate Identity Block -->
                    <div>
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed={{ $sub->candidate->name }}" class="w-10 h-10 border bg-white border-black" alt="Avatar">
                                <div>
                                    <h4 class="font-extrabold text-xs text-slate-900 dark:text-white uppercase tracking-wider">{{ $sub->candidate->name }}</h4>
                                    <span class="block text-[9px] text-slate-400 font-mono truncate max-w-[130px]">{{ $sub->candidate->email }}</span>
                                </div>
                            </div>
                            <span class="text-[8px] font-black px-2 py-0.5 border border-black uppercase tracking-wider
                                {{ $sub->status === 'submitted' ? 'bg-black text-white dark:bg-white dark:text-black' : 'bg-slate-50 text-slate-700 dark:bg-zinc-950 dark:text-zinc-300' }}">
                                {{ $sub->status === 'submitted' ? 'Submitted' : 'In Progress' }}
                            </span>
                        </div>

                        <!-- Suspicion Progress Bar -->
                        <div class="mt-6">
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest mb-1.5">
                                <span class="text-slate-400">Suspicion Risk Meter</span>
                                <span class="font-mono {{ $sub->cheating_score >= 60 ? 'text-rose-650 animate-pulse font-black' : 'text-slate-750 dark:text-zinc-300' }}">{{ $sub->cheating_score }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-zinc-800 rounded-none h-2.5 overflow-hidden border border-black">
                                <div class="h-full transition-all duration-500
                                    {{ $sub->cheating_score >= 60 ? 'bg-rose-600' : ($sub->cheating_score >= 30 ? 'bg-amber-500' : 'bg-black dark:bg-white') }}"
                                    style="width: {{ $sub->cheating_score }}%"></div>
                            </div>
                        </div>

                        <!-- Progress stats -->
                        <div class="mt-5 grid grid-cols-2 gap-3 text-[10px] bg-slate-50 dark:bg-zinc-950 p-3 border border-black/10 dark:border-zinc-800 uppercase font-bold tracking-wider">
                            <div>
                                <span class="block text-[8px] text-slate-400 uppercase">Q. Answered</span>
                                <span class="text-slate-800 dark:text-zinc-200 block mt-0.5">{{ count($sub->answers ?? []) }} Questions</span>
                            </div>
                            <div>
                                <span class="block text-[8px] text-slate-400 uppercase">Timer Log</span>
                                <span class="text-slate-800 dark:text-zinc-200 font-mono block mt-0.5">{{ gmdate('H:i:s', $sub->duration_taken_seconds ?? 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Webcam Snapshots Simulator View -->
                    <div class="mt-5 p-3 bg-zinc-950 text-white font-mono text-[9px] leading-relaxed relative min-h-[140px] flex flex-col justify-between border border-black">
                        <div class="absolute top-2 right-2 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-rose-650 animate-ping"></span>
                            <span class="text-[7px] font-bold text-rose-500 uppercase tracking-widest">Surveillance Feed</span>
                        </div>
                        
                        <div class="w-full h-24 bg-zinc-900 flex items-center justify-center overflow-hidden border border-zinc-800 relative">
                            <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed={{ $sub->candidate->name }}" class="w-12 h-12 rounded bg-zinc-800 p-1 opacity-80" alt="Camera Feed">
                        </div>

                        <div class="mt-2 text-zinc-500 text-center uppercase tracking-widest">
                            Audit Snaps Active
                        </div>
                    </div>

                    <!-- Action Controls -->
                    <div class="mt-5 pt-4 border-t border-black/10 dark:border-zinc-850 flex gap-2">
                        <button 
                            @click="warningModal = true; warningCandidateId = '{{ $sub->candidate->id }}'; warningCandidateName = '{{ $sub->candidate->name }}'; warningMessage = ''" 
                            class="flex-1 py-2.5 border border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white font-bold text-[9px] uppercase tracking-widest transition-colors shadow-3d-stark">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i>Issue Warning
                        </button>
                        <a 
                            href="{{ route('organizer.report-export', $exam->id) }}" 
                            target="_blank"
                            class="flex-1 py-2.5 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-bold text-[9px] uppercase tracking-widest hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all text-center shadow-3d">
                            <i class="fa-solid fa-file-pdf mr-1"></i>View Audit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- WARNING DISPATCHER MODAL (Alpine.js) -->
    <div x-show="warningModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" x-transition.opacity>
        <div class="bg-white dark:bg-black w-full max-w-md mx-4 border-2 border-black dark:border-white shadow-3d p-6" @click.away="warningModal = false">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-black dark:border-zinc-800">
                <h3 class="text-sm font-black uppercase text-slate-900 dark:text-white"><i class="fa-solid fa-bullhorn text-amber-500 mr-2"></i>Issue Proctor Warning</h3>
                <button @click="warningModal = false" class="text-slate-400 hover:text-black"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <!-- Warning form -->
            <div class="space-y-4">
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Target Candidate</label>
                    <div class="font-extrabold text-slate-800 dark:text-white text-sm" x-text="warningCandidateName"></div>
                </div>
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Proctor Warning Message</label>
                    <textarea 
                        x-model="warningMessage" 
                        rows="3" 
                        required
                        class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm" 
                        placeholder="e.g. Please adjust your camera angle to capture your full face profile. Fullscreen restrictions must be respected..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="warningModal = false" class="px-4 py-2 border border-slate-200 text-slate-600 dark:border-zinc-850 dark:text-zinc-400 text-xs font-bold uppercase tracking-wider">Cancel</button>
                    <button 
                        type="button" 
                        @click="
                            if(!warningMessage.trim()) return;
                            fetch('{{ route('proctor.warn') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    candidate_id: warningCandidateId,
                                    message: warningMessage
                                })
                            }).then(r => r.json()).then(data => {
                                if(data.status === 'success') {
                                    alert('Warning dispatched successfully.');
                                    warningModal = false;
                                }
                            });
                        "
                        class="px-4 py-2 bg-black text-white dark:bg-white dark:text-black border-2 border-black dark:border-white text-xs font-black uppercase tracking-widest shadow-3d-stark">
                        Broadcast Warning
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
