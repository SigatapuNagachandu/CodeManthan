<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeManthan Audit Sheet - {{ $exam->title }}</title>
    
    <!-- Outfit Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .print-page-break { page-break-after: always; }
        }
        body { font-family: 'Outfit', sans-serif; background-color: #fafafa; }
    </style>
</head>
<body class="text-slate-800 antialiased p-8 min-h-screen flex flex-col justify-between">

    <!-- Print Floating Dashboard controls -->
    <div class="no-print max-w-5xl mx-auto w-full mb-8 flex justify-between items-center p-4 bg-white border border-slate-200 shadow-md rounded-2xl">
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-violet-600 animate-pulse"></span>
            <span class="text-sm font-bold text-slate-800">Print-Friendly Candidate Audit Sheet</span>
        </div>
        <button onclick="window.print();" class="px-5 py-2.5 bg-violet-600 hover:bg-violet-500 text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-1.5 transition-colors">
            <i class="fa-solid fa-print"></i> Print / Save PDF
        </button>
    </div>

    <!-- Document Wrapper -->
    <div class="max-w-5xl mx-auto w-full bg-white border border-slate-200/60 p-10 rounded-3xl shadow-sm flex-grow">
        
        <!-- Header Branding & Date -->
        <div class="flex justify-between items-start pb-8 mb-8 border-b border-slate-200/80">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-violet-600 to-cyan-500 flex items-center justify-center">
                        <i class="fa-solid fa-shield-halved text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-lg text-slate-900 tracking-tight">CodeManthan</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-950 tracking-tight">Hackathon Candidate Screening Audit</h1>
                <p class="text-xs text-slate-400 mt-1 font-semibold">Platform: Laravel 12 + MongoDB Database Cluster</p>
            </div>
            <div class="text-right">
                <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded bg-violet-100 text-violet-700 uppercase tracking-wider mb-2">{{ $exam->hackathon->title }}</span>
                <p class="text-xs text-slate-400 font-mono">Date Generated: {{ date('F d, Y') }}</p>
            </div>
        </div>

        <!-- Exam Parameters Box -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-6 bg-slate-50 border border-slate-100 rounded-2xl mb-8 text-center">
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase">Assessment Name</span>
                <span class="text-xs font-bold text-slate-800 block mt-1 truncate">{{ $exam->title }}</span>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase">Total Submissions</span>
                <span class="text-sm font-extrabold text-slate-950 block mt-1">{{ $totalSubmissions }} Attempts</span>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase">Average Score</span>
                <span class="text-sm font-extrabold text-slate-950 block mt-1">{{ round($averageScore, 1) }} Points</span>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-slate-400 uppercase">Proctor Trust Rate</span>
                <span class="text-sm font-extrabold text-green-600 block mt-1">{{ round(100 - $averageCheatingScore, 1) }}% Trust</span>
            </div>
        </div>

        <!-- Registered Candidates Leaderboard Grid -->
        <h3 class="text-base font-bold text-slate-950 mb-4 uppercase tracking-wider"><i class="fa-solid fa-ranking-stars text-violet-600 mr-2"></i>Ranked Candidate Screening Sheets</h3>
        
        @if($submissions->isEmpty())
            <p class="text-sm text-slate-400 text-center py-12 border border-dashed rounded-2xl border-slate-200">No attempts registered yet for this examination.</p>
        @else
            <div class="border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100/80 border-b border-slate-200/80">
                            <th class="p-4 font-bold uppercase tracking-wider text-slate-500 w-12 text-center">Rank</th>
                            <th class="p-4 font-bold uppercase tracking-wider text-slate-500">Candidate Information</th>
                            <th class="p-4 font-bold uppercase tracking-wider text-slate-500 text-center">Screening Score</th>
                            <th class="p-4 font-bold uppercase tracking-wider text-slate-500 text-center">Answer Accuracy</th>
                            <th class="p-4 font-bold uppercase tracking-wider text-slate-500 text-center">Suspicion Meter</th>
                            <th class="p-4 font-bold uppercase tracking-wider text-slate-500 text-center w-28">Integrity Seal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/50">
                        @foreach($submissions as $index => $sub)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 text-center font-extrabold text-slate-400 font-mono">#{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $sub->candidate->profile_picture ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed='.$sub->candidate->name }}" class="w-8 h-8 rounded-full border bg-slate-50 border-slate-200 shrink-0" alt="Avatar">
                                        <div>
                                            <span class="block font-bold text-slate-900">{{ $sub->candidate->name }}</span>
                                            <span class="block text-[10px] text-slate-400 font-mono">{{ $sub->candidate->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-extrabold text-slate-950 font-mono">{{ $sub->score }}</span>
                                    <span class="text-slate-400">/{{ $exam->questions->sum('points') }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-semibold text-slate-700 font-mono">{{ count($sub->answers ?? []) }} / {{ $exam->questions->count() }} Q.</span>
                                </td>
                                <td class="p-4 text-center font-mono font-bold
                                    {{ $sub->cheating_score >= 60 ? 'text-rose-600' : ($sub->cheating_score >= 30 ? 'text-amber-500' : 'text-emerald-600') }}">
                                    {{ $sub->cheating_score }}% Prob.
                                </td>
                                <td class="p-4 text-center">
                                    @if($sub->cheating_score >= 60)
                                        <span class="inline-block text-[9px] font-bold px-2 py-1 rounded bg-rose-50 text-rose-600 uppercase tracking-wide border border-rose-200">
                                            🚨 Flagged
                                        </span>
                                    @elseif($sub->cheating_score >= 30)
                                        <span class="inline-block text-[9px] font-bold px-2 py-1 rounded bg-amber-50 text-amber-600 uppercase tracking-wide border border-amber-200">
                                            ⚠️ Suspect
                                        </span>
                                    @else
                                        <span class="inline-block text-[9px] font-bold px-2 py-1 rounded bg-green-50 text-green-700 uppercase tracking-wide border border-green-200">
                                            ✓ Compliant
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        
        <!-- GDPR & Proctor Integrity details -->
        <div class="mt-10 p-5 rounded-2xl bg-slate-50 border border-slate-100 text-[10px] text-slate-400 font-medium leading-relaxed">
            <h4 class="font-bold text-slate-600 uppercase tracking-wider mb-1"><i class="fa-solid fa-circle-info mr-1"></i>Security Architecture Notes</h4>
            CodeManthan implements real-time full-screen triggers, Page Visibility blur locks, webcam stream audits, and text clip copy restrictions. Aggregated cheating scores represent mathematical risk frequencies. Organizer evaluation must complement candidate trust flags prior to final shortlists.
        </div>
    </div>

    <!-- Document Footer -->
    <div class="max-w-5xl mx-auto w-full mt-6 text-center text-[10px] text-slate-400 font-semibold uppercase tracking-widest no-print">
        CodeManthan © {{ date('Y') }} • Verified Cryptographic Audit Document
    </div>
</body>
</html>
