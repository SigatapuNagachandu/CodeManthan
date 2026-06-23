@extends('layouts.app')

@section('title', 'Candidate Dashboard - CodeManthan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Lobby Banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-6 border-b-2 border-black dark:border-zinc-800">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white">Candidate Lobby</h1>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550 mt-1">Register for screenings, sit for secure assessments, and review technical reports.</p>
        </div>
        <div class="text-right shrink-0">
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Compliance Status</span>
            <span class="block text-sm font-extrabold text-green-600 dark:text-green-400 uppercase mt-1"><i class="fa-solid fa-heart-pulse mr-1"></i>Verified Clear</span>
        </div>
    </div>

    <!-- Candidate Stats Grid -->
    <div class="grid grid-cols-3 gap-6 mb-10">
        <!-- Stat Card 1 -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex items-center gap-5">
            <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0">
                <i class="fa-solid fa-pen-nib text-base"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Attempted</p>
                <h3 class="text-xl font-black text-slate-950 dark:text-white mt-1 font-mono">{{ $examsAttempted }} Exams</h3>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex items-center gap-5">
            <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0">
                <i class="fa-solid fa-clipboard-check text-base"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Completed</p>
                <h3 class="text-xl font-black text-slate-950 dark:text-white mt-1 font-mono">{{ $completedExams }} Exams</h3>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex items-center gap-5">
            <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0">
                <i class="fa-solid fa-trophy text-base"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Average Score</p>
                <h3 class="text-xl font-black text-slate-950 dark:text-white mt-1 font-mono">{{ round($averageScore, 1) }} pts</h3>
            </div>
        </div>
    </div>

    <!-- Analytics Curve & System Notifications Panel -->
    <div class="grid lg:grid-cols-3 gap-6 mb-10">
        <!-- Performance Trend Curve Chart -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xs font-black uppercase text-slate-900 dark:text-white"><i class="fa-solid fa-chart-line text-black dark:text-white mr-2"></i>My Performance Trend</h4>
                <span class="text-[10px] font-bold text-slate-400">Score History</span>
            </div>
            <div class="h-64">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- System Notifications & Alerts Feed -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d">
            <h4 class="text-xs font-black uppercase text-slate-900 dark:text-white mb-6 pb-2 border-b border-black/10 dark:border-zinc-800">
                <i class="fa-solid fa-bell text-black dark:text-white mr-2"></i>Inbox Alerts
            </h4>
            
            <div class="space-y-4 max-h-[250px] overflow-y-auto pr-1">
                @forelse($notifications as $notif)
                    <div class="p-3.5 border border-black/10 dark:border-zinc-800 bg-slate-50/50 dark:bg-zinc-950/20 flex gap-2.5">
                        <div class="w-7 h-7 bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0 border border-black">
                            <i class="fa-solid {{ $notif->type === 'cheating_warning' ? 'fa-triangle-exclamation' : 'fa-info' }} text-xs"></i>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-zinc-200 uppercase tracking-wide">{{ $notif->title }}</span>
                            <span class="block text-[10px] text-slate-500 mt-0.5 leading-relaxed font-medium uppercase tracking-wider">{{ $notif->message }}</span>
                            <span class="block text-[9px] text-slate-400 font-mono mt-1.5 uppercase font-bold">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center py-10 my-auto"><i class="fa-solid fa-envelope-open mr-1"></i>Inbox empty.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Active Assessments & Available Hackathons Grids -->
    <div class="grid lg:grid-cols-2 gap-8">
        
        <!-- Column 1: Active Assessments I Can Sit For -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d">
            <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white mb-6"><i class="fa-solid fa-graduation-cap text-black dark:text-white mr-2"></i>My Screening Exams</h3>
            
            <div class="space-y-4">
                @forelse($allHackathons as $hack)
                    @foreach($hack->exams as $exam)
                        @php
                            $sub = $submissions->where('exam_id', $exam->id)->first();
                        @endphp
                        
                        <div class="p-4 bg-slate-50/50 dark:bg-zinc-900/30 border border-black/15 dark:border-zinc-800 rounded-none flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                            <div>
                                <span class="inline-block text-[8px] font-black px-1.5 py-0.5 border border-black dark:border-zinc-700 bg-black dark:bg-zinc-850 text-white uppercase tracking-widest">{{ $hack->title }}</span>
                                <h4 class="font-extrabold text-sm text-slate-900 dark:text-white mt-2 uppercase tracking-wide">{{ $exam->title }}</h4>
                                <span class="block text-[9px] text-slate-400 font-mono mt-1 uppercase font-bold"><i class="fa-regular fa-clock mr-1"></i>{{ $exam->duration_minutes }} min • {{ $exam->questions->count() }} Qs.</span>
                            </div>

                            <div class="shrink-0 self-end sm:self-auto">
                                @if($sub && $sub->status === 'submitted')
                                    <a href="{{ route('candidate.exam-result', $exam->id) }}" class="inline-flex text-[9px] font-black uppercase tracking-widest px-4 py-2.5 border-2 border-black dark:border-zinc-800 bg-slate-50 hover:bg-black hover:text-white dark:bg-zinc-900 dark:hover:bg-white dark:hover:text-black text-black dark:text-white transition-all shadow-3d-stark">
                                        <i class="fa-solid fa-square-poll-vertical mr-1.5"></i>Review Grade
                                    </a>
                                @elseif($sub && $sub->status === 'in_progress')
                                    <a href="{{ route('candidate.exam-screen', $exam->id) }}" class="inline-flex text-[9px] font-black uppercase tracking-widest px-4 py-2.5 bg-black text-white dark:bg-white dark:text-black border-2 border-black dark:border-white shadow-3d animate-pulse">
                                        <i class="fa-solid fa-circle-play mr-1.5"></i>Resume Test
                                    </a>
                                @else
                                    <a href="{{ route('candidate.exam-room', $exam->id) }}" class="inline-flex text-[9px] font-black uppercase tracking-widest px-4 py-2.5 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white shadow-3d hover:-translate-y-0.5 transition-all">
                                        Sit Screening
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @empty
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center py-10"><i class="fa-solid fa-triangle-exclamation mr-1"></i>No assessments loaded.</p>
                @endforelse
            </div>
        </div>

        <!-- Column 2: Available Open Hackathons to Register -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d">
            <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white mb-6"><i class="fa-solid fa-cubes text-black dark:text-white mr-2"></i>Global Hackathons</h3>
            
            <div class="space-y-4">
                @foreach($allHackathons as $hack)
                    <div class="p-4 bg-slate-50/50 dark:bg-zinc-900/30 border border-black/15 dark:border-zinc-800 rounded-none flex flex-col justify-between gap-4">
                        <div>
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider">{{ $hack->title }}</h4>
                            <p class="text-[11px] font-semibold text-slate-400 dark:text-zinc-550 mt-1.5 leading-relaxed line-clamp-2 uppercase tracking-wide">{{ $hack->description }}</p>
                        </div>
                        <div class="flex items-center justify-between border-t border-black/10 dark:border-zinc-800 pt-3">
                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider"><i class="fa-regular fa-calendar mr-1"></i>Starts {{ $hack->start_date->format('M d, Y') }}</span>
                            <form action="{{ route('candidate.hackathon-register', $hack->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[9px] font-black uppercase tracking-widest px-4 py-2 border border-black dark:border-zinc-700 bg-white dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white transition-all shadow-3d-stark">
                                    Register Now
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($performanceData['labels']) !!},
            datasets: [{
                label: 'Points Secured',
                data: {!! json_encode($performanceData['scores']) !!},
                borderColor: '#000000',
                backgroundColor: 'rgba(0,0,0,0.03)',
                borderWidth: 2,
                tension: 0.15,
                fill: true,
                pointBackgroundColor: '#000000',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { font: { family: 'Outfit', size: 10 } } },
                x: { grid: { display: false }, ticks: { font: { family: 'Outfit', size: 10 } } }
            }
        }
    });
</script>
@endsection
