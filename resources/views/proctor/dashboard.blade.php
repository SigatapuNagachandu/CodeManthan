@extends('layouts.app')

@section('title', 'Proctor Terminal - AegisProctor Security Hub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ warningModal: false, warningCandidateId: '', warningCandidateName: '', warningMessage: '' }">
    
    <!-- Header Summary -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-6 border-b-2 border-black dark:border-zinc-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 pulse-glow-green shrink-0"></span>
                <span class="text-xs font-black uppercase text-emerald-500 tracking-widest">Active Proctor Security Terminal</span>
            </div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white mt-1">Proctor Control Center</h1>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550 mt-1">Audit live camera feeds, inspect infraction severity indices, and dispatch alerts.</p>
        </div>
        <a href="{{ route('landing') }}" class="px-4 py-2.5 border border-slate-200 dark:border-zinc-800 text-slate-700 dark:text-zinc-300 font-bold text-xs uppercase hover:bg-slate-50 transition-colors">
            <i class="fa-solid fa-home mr-2"></i>Return Home
        </a>
    </div>

    <!-- Active Candidates Feeds Grid -->
    <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white mb-6"><i class="fa-solid fa-users text-black dark:text-white mr-2"></i>Active Candidates Streams ({{ $activeSubmissions->count() }})</h3>
    
    @if($activeSubmissions->isEmpty())
        <div class="p-12 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d text-center mb-10">
            <div class="w-10 h-10 border border-black dark:border-white bg-slate-50 dark:bg-zinc-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                <i class="fa-solid fa-camera text-base animate-pulse"></i>
            </div>
            <h4 class="text-xs font-bold uppercase text-slate-950 dark:text-white">All Cameras Quiet</h4>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">No candidate screening exams are currently active.</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            @foreach($activeSubmissions as $sub)
                <div class="p-5 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex flex-col justify-between min-h-[260px]
                    {{ $sub->cheating_score >= 60 ? 'border-rose-400 bg-rose-500/[0.01]' : '' }}">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[8px] font-black px-1.5 py-0.5 border border-black bg-black text-white dark:bg-white dark:text-black uppercase tracking-wide truncate max-w-[120px]">
                                {{ $sub->exam->title }}
                            </span>
                            <span class="w-2 h-2 bg-rose-600 pulse-glow-red"></span>
                        </div>

                        <!-- Live Visual Frame Mock -->
                        <div class="w-full h-32 bg-zinc-950 border border-black dark:border-zinc-800 rounded-none overflow-hidden relative mb-3 flex items-center justify-center">
                            <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed={{ $sub->candidate->name }}" class="w-14 h-14 rounded bg-zinc-800 p-1 opacity-80" alt="Snapshot">
                        </div>

                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-xs text-slate-900 dark:text-white">{{ $sub->candidate->name }}</h4>
                            <span class="text-[9px] font-mono text-rose-600 dark:text-rose-400 font-black animate-pulse">{{ $sub->cheating_score }}% Risk</span>
                        </div>
                    </div>

                    <button 
                        @click="warningModal = true; warningCandidateId = '{{ $sub->candidate->id }}'; warningCandidateName = '{{ $sub->candidate->name }}'; warningMessage = ''" 
                        class="w-full mt-3 py-2 border border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-950 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white font-bold text-[9px] uppercase tracking-widest transition-colors shadow-3d-stark">
                        <i class="fa-solid fa-bullhorn mr-1.5"></i>Issue Live Warning
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    <!-- General Violations Incident Log Grid -->
    <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d">
        <h3 class="text-xs font-black uppercase text-slate-950 dark:text-white mb-6 pb-2 border-b border-black/10 dark:border-zinc-800">
            <i class="fa-solid fa-list-check text-black dark:text-white mr-2"></i>Audit Incident Violations Log
        </h3>

        @if($violations->isEmpty())
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center py-10">No incident alerts logged.</p>
        @else
            <div class="border border-black dark:border-zinc-850 rounded-none overflow-hidden shadow-sm">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-zinc-950 border-b-2 border-black dark:border-zinc-850">
                            <th class="p-4 font-black text-slate-500 uppercase tracking-widest">Candidate Info</th>
                            <th class="p-4 font-black text-slate-500 uppercase tracking-widest">Target Examination</th>
                            <th class="p-4 font-black text-slate-500 uppercase tracking-widest text-center">Violation Type</th>
                            <th class="p-4 font-black text-slate-500 uppercase tracking-widest text-center">Severity</th>
                            <th class="p-4 font-black text-slate-500 uppercase tracking-widest text-center">Incident Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/10 dark:divide-zinc-850">
                        @foreach($violations as $vl)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-zinc-900/10">
                                <td class="p-4">
                                    <span class="block font-bold text-slate-900 dark:text-white">{{ $vl->candidate->name ?? 'Candidate' }}</span>
                                    <span class="block text-[9px] text-slate-400 font-mono">{{ $vl->candidate->email ?? '' }}</span>
                                </td>
                                <td class="p-4 font-bold text-slate-600 dark:text-zinc-400 uppercase tracking-wide">
                                    {{ $vl->submission->exam->title ?? 'Screening Test' }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-mono text-rose-600 dark:text-rose-400 font-black uppercase tracking-widest">{{ str_replace('_', ' ', $vl->event_type) }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-block text-[8px] font-black px-2 py-0.5 border border-black dark:border-zinc-800 uppercase tracking-wider
                                        {{ $vl->severity === 'high' ? 'bg-rose-50 text-rose-650' : ($vl->severity === 'medium' ? 'bg-amber-50 text-amber-650' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $vl->severity }}
                                    </span>
                                </td>
                                <td class="p-4 text-center text-slate-400 dark:text-zinc-550 font-mono font-bold">
                                    {{ $vl->created_at->toDateTimeString() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- WARNING DISPATCHER DRAWER MODAL (Alpine.js) -->
    <div x-show="warningModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" x-transition.opacity>
        <div class="bg-white dark:bg-black w-full max-w-md mx-4 border-2 border-black dark:border-white shadow-3d p-6" @click.away="warningModal = false">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-black dark:border-zinc-850">
                <h3 class="text-sm font-black uppercase text-slate-900 dark:text-white"><i class="fa-solid fa-bullhorn text-amber-500 mr-2"></i>Issue Live Warning</h3>
                <button @click="warningModal = false" class="text-slate-400 hover:text-black"><i class="fa-solid fa-xmark"></i></button>
            </div>

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
                        placeholder="e.g. Tab switches are prohibited. Adjust camera focus immediately..."></textarea>
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
