@extends('layouts.app')

@section('title', 'Screening Complete - CodeManthan Security Hub')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Sleek Breadcrumb Back Link -->
    <div class="mb-6">
        <a href="{{ route('candidate.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-slate-500 hover:text-black dark:text-zinc-400 dark:hover:text-white transition-colors duration-150">
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            Back to Dashboard
        </a>
    </div>

    <!-- Congratulations card -->
    <div class="p-8 sm:p-10 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d text-center relative overflow-hidden">
        
        <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center text-lg mx-auto mb-6 shadow-md animate-bounce">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </div>

        <h1 class="text-2xl font-black uppercase tracking-tight text-slate-900 dark:text-white">Screening Sheet Committed!</h1>
        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550 mt-2 max-w-sm mx-auto">
            Your screening solutions have been securely stored in our MongoDB cluster.
        </p>

        <!-- Dynamic Results Score panel -->
        <div class="grid grid-cols-2 gap-4 max-w-md mx-auto my-8 p-5 border-2 border-black bg-slate-50 dark:bg-zinc-900/50">
            <div class="text-center border-r border-black/20">
                <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Secured Grade</span>
                <span class="text-3xl font-black text-slate-950 dark:text-white mt-1 block font-mono">
                    {{ $submission->score }}<span class="text-xs text-slate-400">/{{ $exam->questions->sum('points') }}</span>
                </span>
            </div>
            <div class="text-center">
                <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Proctor Integrity</span>
                <span class="text-3xl font-black mt-1 block font-mono
                    {{ $submission->cheating_score >= 60 ? 'text-rose-600' : ($submission->cheating_score >= 30 ? 'text-amber-500' : 'text-emerald-500') }}">
                    {{ 100 - $submission->cheating_score }}%<span class="text-xs text-slate-400"> trust</span>
                </span>
            </div>
        </div>

        <!-- Quick Access Return Action -->
        <div class="mb-8">
            <a href="{{ route('candidate.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d cursor-pointer">
                <i class="fa-solid fa-gauge-high"></i>
                Go to Dashboard
            </a>
        </div>

        <!-- AI FEEDBACK CONTAINER -->
        @if($submission->ai_feedback)
            <div class="text-left p-6 border-2 border-black bg-slate-50 dark:bg-zinc-950/20 mb-8 shadow-3d-stark">
                <div class="flex items-center gap-2 text-[10px] font-black text-black dark:text-white uppercase tracking-widest mb-4 pb-2 border-b border-black/15">
                    <i class="fa-solid fa-robot animate-pulse"></i>
                    AI Compliance & Code Review
                </div>
                <div class="text-[11px] font-mono text-slate-600 dark:text-zinc-350 leading-relaxed space-y-2 normal-case">
                    {!! nl2br(e($submission->ai_feedback)) !!}
                </div>
            </div>
        @endif

        <!-- Back to Lobby button -->
        <div class="flex items-center justify-center">
            <a href="{{ route('candidate.dashboard') }}" class="px-6 py-3 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-home"></i>
                Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
