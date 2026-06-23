@extends('layouts.app')

@section('title', 'Organizer Dashboard - CodeManthan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showHackModal: false, showExamModal: false, selectedHackathonId: '' }">
    
    <!-- Dashboard Branding Banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-6 border-b-2 border-black dark:border-zinc-800">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white">Organizer Dashboard</h1>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550 mt-1">Configure screening rounds, monitor suspicious violations, and inspect auditing certificates.</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="showHackModal = true" class="px-5 py-3 border-2 border-black dark:border-white bg-white dark:bg-black text-black dark:text-white font-bold uppercase tracking-widest text-xs transition-all hover:bg-slate-50 dark:hover:bg-zinc-900 shadow-3d-stark">
                <i class="fa-solid fa-folder-plus mr-2"></i>New Hackathon
            </button>
            <button @click="showExamModal = true; selectedHackathonId = '{{ $hackathons->first()->id ?? '' }}'" class="px-5 py-3 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-bold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d">
                <i class="fa-solid fa-square-plus mr-2"></i>Create Exam
            </button>
        </div>
    </div>

    <!-- Core Metrics Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stat Card 1 -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex items-center gap-5">
            <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0">
                <i class="fa-solid fa-cubes text-base"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Hackathons</p>
                <h3 class="text-2xl font-black text-slate-950 dark:text-white mt-1 font-mono">{{ $totalHackathons }}</h3>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex items-center gap-5">
            <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0">
                <i class="fa-solid fa-file-code text-base"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Exams</p>
                <h3 class="text-2xl font-black text-slate-950 dark:text-white mt-1 font-mono">{{ $totalExams }}</h3>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex items-center gap-5">
            <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0">
                <i class="fa-solid fa-file-invoice text-base"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Submissions</p>
                <h3 class="text-2xl font-black text-slate-950 dark:text-white mt-1 font-mono">{{ $totalSubmissions }}</h3>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="p-6 border-2 border-black dark:border-zinc-850 bg-white dark:bg-zinc-900 shadow-3d flex items-center gap-5">
            <div class="w-12 h-12 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0 relative">
                <i class="fa-solid fa-satellite-dish text-base"></i>
                @if($liveCandidates > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
                @endif
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Live Candidates</p>
                <div class="flex items-center gap-2 mt-1">
                    <h3 class="text-2xl font-black text-slate-950 dark:text-white font-mono">{{ $liveCandidates }}</h3>
                    <span class="text-[8px] font-black px-1.5 py-0.5 border border-red-600 text-red-600 uppercase tracking-widest">Live</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section with Charts -->
    <div class="grid lg:grid-cols-3 gap-6 mb-10">
        <!-- Chart Block 1: screening metrics -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xs font-black uppercase text-slate-900 dark:text-white"><i class="fa-solid fa-chart-line text-black dark:text-white mr-2"></i>Screening Activity Curve</h4>
                <span class="text-[10px] font-bold text-slate-400">Past 6 Days</span>
            </div>
            <div class="h-64">
                <canvas id="submissionsChart"></canvas>
            </div>
        </div>

        <!-- Chart Block 2: Proctored Security Pie -->
        <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xs font-black uppercase text-slate-900 dark:text-white"><i class="fa-solid fa-shield-halved text-black dark:text-white mr-2"></i>Proctor Compliance</h4>
                <span class="text-[10px] font-bold text-slate-400">Risk Spectrum</span>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="securityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Main List Grids & Recent Activity Sidebar -->
    <div class="grid lg:grid-cols-3 gap-6">
        
        <!-- Left Side: Hackathons and Exams list -->
        <div class="lg:col-span-2 space-y-6">
            <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white"><i class="fa-solid fa-cubes text-black dark:text-white mr-2"></i>Hackathons & Screenings</h3>
                    <button @click="showHackModal = true" class="text-xs font-black uppercase tracking-wider text-black dark:text-white hover:underline">Add Hackathon</button>
                </div>

                @if($hackathons->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-12 h-12 border border-black dark:border-white bg-slate-50 dark:bg-zinc-800 flex items-center justify-center text-slate-400 mx-auto mb-4">
                            <i class="fa-solid fa-folder-open text-base"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-550 uppercase">No hackathons constructed yet.</p>
                        <button @click="showHackModal = true" class="mt-3 text-[10px] font-black uppercase tracking-wider px-3.5 py-2 bg-black text-white border border-black shadow-3d-stark">Build Your First</button>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($hackathons as $hack)
                            <div class="p-5 border border-black dark:border-zinc-800 bg-slate-50/50 dark:bg-zinc-900/10">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-black/10 dark:border-zinc-850">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-graduation-cap text-base"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider">{{ $hack->title }}</h4>
                                            <div class="flex items-center gap-2 mt-0.5 text-[10px] font-semibold text-slate-400">
                                                <span><i class="fa-regular fa-calendar mr-1"></i>{{ $hack->start_date->format('M d, Y') }}</span>
                                                <span>•</span>
                                                <span>{{ $hack->exams->count() }} active exam(s)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button @click="showExamModal = true; selectedHackathonId = '{{ $hack->id }}'" class="text-[9px] font-black uppercase tracking-widest px-3 py-1.5 border border-black dark:border-zinc-700 bg-white dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white transition-all shadow-3d-stark">
                                        <i class="fa-solid fa-plus-circle mr-1"></i>Add Exam
                                    </button>
                                </div>

                                <!-- Hackathon Exams Inner List -->
                                <div class="mt-4 space-y-3">
                                    @forelse($hack->exams as $exam)
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3 bg-white dark:bg-zinc-950 border border-black/10 dark:border-zinc-850">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-2 h-2 bg-green-500 pulse-glow-green shrink-0"></div>
                                                <div>
                                                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-800 dark:text-zinc-200">{{ $exam->title }}</span>
                                                    <span class="block text-[9px] text-slate-400 font-mono mt-0.5 uppercase"><i class="fa-regular fa-clock mr-1"></i>{{ $exam->duration_minutes }} min • {{ $exam->questions->count() }} questions</span>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 shrink-0 self-end sm:self-auto">
                                                <a href="{{ route('organizer.exam-builder', $exam->id) }}" class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1.5 border border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white transition-all shadow-3d-stark" title="Manage questions"><i class="fa-solid fa-code-fork mr-1"></i>Builder</a>
                                                <a href="{{ route('organizer.live-monitor', $exam->id) }}" class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1.5 border border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white transition-all shadow-3d-stark" title="Watch live"><i class="fa-solid fa-circle-play mr-1"></i>Monitor</a>
                                                <a href="{{ route('organizer.report-export', $exam->id) }}" class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1.5 border border-black dark:border-zinc-850 bg-slate-50 dark:bg-zinc-900 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black text-black dark:text-white transition-all shadow-3d-stark" title="Export audits" target="_blank"><i class="fa-solid fa-file-pdf mr-1"></i>Report</a>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest text-center py-2"><i class="fa-solid fa-info-circle mr-1"></i>No exams configured.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Recent violations audit log -->
        <div class="space-y-6">
            <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d flex flex-col min-h-[400px]">
                <div class="flex items-center justify-between mb-6 pb-2 border-b border-black/10 dark:border-zinc-850">
                    <h3 class="text-xs font-black uppercase text-slate-950 dark:text-white"><i class="fa-solid fa-bell text-black dark:text-white mr-2"></i>Live Incident Feed</h3>
                    <span class="text-[8px] font-black px-2 py-0.5 border border-black text-black dark:border-white dark:text-white uppercase tracking-widest">Proctored</span>
                </div>

                @if($recentEvents->isEmpty())
                    <div class="text-center py-12 my-auto">
                        <div class="w-10 h-10 border border-black dark:border-white bg-slate-50 dark:bg-zinc-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                            <i class="fa-solid fa-shield text-base"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">All quiet. No incident infractions reported.</p>
                    </div>
                @else
                    <div class="space-y-4 flex-grow overflow-y-auto max-h-[380px] pr-1">
                        @foreach($recentEvents as $event)
                            <div class="p-3.5 border border-black dark:border-zinc-800 bg-slate-50/50 dark:bg-zinc-900/10">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-800 dark:text-white">{{ $event->candidate->name ?? 'Candidate' }}</span>
                                    <span class="text-[8px] font-black px-1.5 py-0.5 border border-black dark:border-zinc-800 uppercase tracking-wider
                                        {{ $event->severity === 'high' ? 'bg-rose-50 text-rose-600' : ($event->severity === 'medium' ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-600') }}">
                                        {{ $event->severity }}
                                    </span>
                                </div>
                                <p class="text-[10px] font-bold text-slate-500 dark:text-zinc-400 mt-1 uppercase tracking-wide">
                                    🚨 Incident: <span class="font-mono text-rose-600 dark:text-rose-450">{{ str_replace('_', ' ', $event->event_type) }}</span>
                                </p>
                                <div class="flex justify-between items-center mt-2.5 text-[9px] text-slate-400 font-semibold uppercase">
                                    <span>{{ $event->created_at->diffForHumans() }}</span>
                                    <a href="{{ route('organizer.live-monitor', $event->submission->exam_id ?? '') }}" class="font-black text-black dark:text-white hover:underline">Monitor Feed</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- HACKATHON CREATOR MODAL (Alpine.js) -->
    <div x-show="showHackModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" x-transition.opacity>
        <div class="bg-white dark:bg-black w-full max-w-lg mx-4 border-2 border-black dark:border-white shadow-3d p-6" @click.away="showHackModal = false">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-black dark:border-zinc-800">
                <h3 class="text-sm font-black uppercase text-slate-900 dark:text-white"><i class="fa-solid fa-folder-plus text-black dark:text-white mr-2"></i>Create New Hackathon</h3>
                <button @click="showHackModal = false" class="text-slate-400 hover:text-black"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="{{ route('organizer.hackathon') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Hackathon Title</label>
                    <input type="text" name="title" required class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm" placeholder="Global AI Innovation League">
                </div>
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Description Summary</label>
                    <textarea name="description" required rows="3" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm" placeholder="Describe goals and shortlisting stakes..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Start Date</label>
                        <input type="datetime-local" name="start_date" required class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm">
                    </div>
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">End Date</label>
                        <input type="datetime-local" name="end_date" required class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Banner URL</label>
                    <input type="url" name="banner_image" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm" placeholder="https://images.unsplash.com/...">
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="showHackModal = false" class="px-5 py-2.5 border border-slate-200 text-slate-600 dark:border-zinc-800 dark:text-zinc-400 text-xs font-bold uppercase tracking-wider">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-black text-white dark:bg-white dark:text-black border-2 border-black dark:border-white text-xs font-black uppercase tracking-widest shadow-3d-stark">Inaugurate Hackathon</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EXAM INITIALIZER MODAL (Alpine.js) -->
    <div x-show="showExamModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" x-transition.opacity>
        <div class="bg-white dark:bg-black w-full max-w-lg mx-4 border-2 border-black dark:border-white shadow-3d p-6" @click.away="showExamModal = false">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-black dark:border-zinc-800">
                <h3 class="text-sm font-black uppercase text-slate-900 dark:text-white"><i class="fa-solid fa-square-plus text-black dark:text-white mr-2"></i>Configure Proctored Exam</h3>
                <button @click="showExamModal = false" class="text-slate-400 hover:text-black"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="{{ route('organizer.exam') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Select Hackathon</label>
                    @if($hackathons->isEmpty())
                        <div class="p-3.5 border-2 border-black bg-rose-50 dark:bg-rose-950/20 text-rose-650 dark:text-rose-400 text-[10px] font-black uppercase tracking-widest flex items-center justify-between gap-3">
                            <span>No Hackathons Constructed Yet.</span>
                            <button type="button" @click="showExamModal = false; showHackModal = true" class="underline text-black dark:text-white font-extrabold hover:opacity-80">Build One</button>
                        </div>
                    @else
                        <select name="hackathon_id" x-model="selectedHackathonId" required class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm">
                            @foreach($hackathons as $hack)
                                <option value="{{ $hack->id }}">{{ $hack->title }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Exam Title</label>
                    <input type="text" name="title" required :disabled="{{ $hackathons->isEmpty() ? 'true' : 'false' }}" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm disabled:opacity-40" placeholder="General MCQ & Coding Screening">
                </div>
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Instructions & Consent Rules</label>
                    <textarea name="description" required rows="3" :disabled="{{ $hackathons->isEmpty() ? 'true' : 'false' }}" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm disabled:opacity-40" placeholder="Pre-exam checkpoint statements..."></textarea>
                </div>
                <div>
                    <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Duration (Minutes)</label>
                    <input type="number" name="duration_minutes" required min="5" max="480" value="60" :disabled="{{ $hackathons->isEmpty() ? 'true' : 'false' }}" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm disabled:opacity-40">
                </div>
 
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="showExamModal = false" class="px-5 py-2.5 border border-slate-200 text-slate-600 dark:border-zinc-800 dark:text-zinc-400 text-xs font-bold uppercase tracking-wider">Cancel</button>
                    <button type="submit" :disabled="{{ $hackathons->isEmpty() ? 'true' : 'false' }}" class="px-5 py-2.5 bg-black text-white dark:bg-white dark:text-black border-2 border-black dark:border-white text-xs font-black uppercase tracking-widest shadow-3d-stark disabled:opacity-30 disabled:cursor-not-allowed">Configure Exam</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monochrome Palette Configurations for Chart.js
    const fontConfig = { family: 'Outfit', size: 11 };

    // 1. Line Chart Setup
    const ctxSub = document.getElementById('submissionsChart').getContext('2d');
    new Chart(ctxSub, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartsData['submissionLabels']) !!},
            datasets: [{
                label: 'Submissions',
                data: {!! json_encode($chartsData['submissionValues']) !!},
                borderColor: '#09090b',
                backgroundColor: 'rgba(9, 9, 11, 0.05)',
                borderWidth: 2,
                tension: 0.2,
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
                y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 5, font: fontConfig } },
                x: { grid: { display: false }, ticks: { font: fontConfig } }
            }
        }
    });

    // 2. Doughnut Security Chart Setup (B&W contrast scales)
    const ctxSec = document.getElementById('securityChart').getContext('2d');
    new Chart(ctxSec, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartsData['cheatingLabels']) !!},
            datasets: [{
                data: {!! json_encode($chartsData['cheatingValues']) !!},
                backgroundColor: ['#000000', '#52525b', '#a1a1aa', '#e4e4e7'],
                borderWidth: 1,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, font: fontConfig }
                }
            }
        }
    });
</script>
@endsection
