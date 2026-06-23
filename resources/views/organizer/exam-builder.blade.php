@extends('layouts.app')

@section('title', 'Exam Builder - CodeManthan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ qType: 'mcq' }">
    
    <!-- Navigation Breadcrumbs -->
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase mb-4">
        <a href="{{ route('organizer.dashboard') }}" class="hover:text-black dark:hover:text-white">Organizer Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
        <span>Exam Builder</span>
    </div>

    <!-- Exam Info Summary Banner -->
    <div class="p-6 sm:p-8 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="inline-block text-[8px] font-black px-2 py-0.5 border border-black bg-black text-white dark:bg-white dark:text-black uppercase tracking-widest">{{ $exam->hackathon->title }}</span>
            <h1 class="text-2xl sm:text-3xl font-black uppercase text-slate-900 dark:text-white mt-1">{{ $exam->title }}</h1>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-450 dark:text-zinc-500 mt-2 max-w-xl">{{ $exam->description }}</p>
        </div>
        <div class="flex items-center gap-4 shrink-0 font-bold uppercase tracking-wider">
            <div class="text-center px-4 border-r-2 border-black/10 dark:border-zinc-800">
                <span class="block text-[9px] text-slate-400 uppercase tracking-widest">Duration</span>
                <span class="text-lg font-black text-slate-900 dark:text-white font-mono mt-0.5 block">{{ $exam->duration_minutes }} min</span>
            </div>
            <div class="text-center px-4">
                <span class="block text-[9px] text-slate-400 uppercase tracking-widest">Secured</span>
                <span class="text-lg font-black text-slate-900 dark:text-white font-mono mt-0.5 block">{{ $exam->questions->sum('points') }} pts</span>
            </div>
        </div>
    </div>

    <!-- Two Column Grid: builder forms and list of questions -->
    <div class="grid lg:grid-cols-5 gap-8">
        
        <!-- Left 3 Columns: Inject Question Panel -->
        <div class="lg:col-span-3 space-y-6">
            <div class="p-6 sm:p-8 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d">
                <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white mb-4"><i class="fa-solid fa-square-plus text-black dark:text-white mr-2"></i>Incorporate Screening Question</h3>
                
                <!-- Swappable Type Pills -->
                <div class="flex p-1 bg-slate-100 dark:bg-zinc-950 border border-black rounded-none gap-1 mb-6">
                    <button @click="qType = 'mcq'" :class="qType === 'mcq' ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-3 text-xs font-bold uppercase tracking-wider transition-all duration-150">
                        <i class="fa-solid fa-circle-dot mr-1"></i>MCQ Screening
                    </button>
                    <button @click="qType = 'coding'" :class="qType === 'coding' ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-3 text-xs font-bold uppercase tracking-wider transition-all duration-150">
                        <i class="fa-solid fa-laptop-code mr-1"></i>Coding Snippet
                    </button>
                </div>

                <!-- Form Panel -->
                <form action="{{ route('organizer.question', $exam->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" :value="qType">

                    <!-- Question difficulty and points -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Points Weight</label>
                            <input type="number" name="points" required min="1" value="10" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Difficulty Scale</label>
                            <select name="difficulty" required class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm text-slate-900 dark:text-white">
                                <option value="easy">Easy</option>
                                <option value="medium" selected>Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                    </div>

                    <!-- Question Prompt text -->
                    <div>
                        <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Question Prompt Text</label>
                        <textarea name="question_text" required rows="3" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm text-slate-900 dark:text-white" placeholder="Type the question content or program objective description..."></textarea>
                    </div>

                    <!-- MCQ FIELDS BLOCK (Show if qType is mcq) -->
                    <div class="space-y-4 pt-2 border-t-2 border-black/10 dark:border-zinc-800" x-show="qType === 'mcq'">
                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">MCQ Answer Options</div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400 font-mono w-4">A</span>
                                <input type="text" name="options[]" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border border-black dark:border-zinc-800 rounded-none text-sm" placeholder="Option A description..." :required="qType === 'mcq'">
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400 font-mono w-4">B</span>
                                <input type="text" name="options[]" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border border-black dark:border-zinc-800 rounded-none text-sm" placeholder="Option B description..." :required="qType === 'mcq'">
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400 font-mono w-4">C</span>
                                <input type="text" name="options[]" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border border-black dark:border-zinc-800 rounded-none text-sm" placeholder="Option C description...">
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400 font-mono w-4">D</span>
                                <input type="text" name="options[]" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border border-black dark:border-zinc-800 rounded-none text-sm" placeholder="Option D description...">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Specify Correct Option index (0-indexed)</label>
                            <select name="correct_answer" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-sm text-slate-900 dark:text-white" :required="qType === 'mcq'">
                                <option value="0">Index 0 (Option A)</option>
                                <option value="1">Index 1 (Option B)</option>
                                <option value="2">Index 2 (Option C)</option>
                                <option value="3">Index 3 (Option D)</option>
                            </select>
                        </div>
                    </div>

                    <!-- CODING FIELDS BLOCK (Show if qType is coding) -->
                    <div class="space-y-4 pt-2 border-t-2 border-black/10 dark:border-zinc-800" x-show="qType === 'coding'">
                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Monaco Code Templates</div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[8px] font-bold text-slate-400 uppercase mb-1">Python 3 Starter</label>
                                <textarea name="coding_template_python" rows="4" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-xs font-mono" placeholder="def solve(x):&#10;    pass" :required="qType === 'coding'"></textarea>
                            </div>
                            <div>
                                <label class="block text-[8px] font-bold text-slate-400 uppercase mb-1">Javascript Starter</label>
                                <textarea name="coding_template_javascript" rows="4" class="block w-full p-3 bg-slate-50 dark:bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none text-xs font-mono" placeholder="function solve(x) {&#10;    return x;&#10;}" :required="qType === 'coding'"></textarea>
                            </div>
                        </div>

                        <!-- Test Cases block -->
                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-4">Screening Test Cases</div>
                        <div class="p-4 border border-black dark:border-zinc-850 bg-slate-50/50 dark:bg-zinc-950/20 space-y-4">
                            <div>
                                <h4 class="text-[9px] font-black text-slate-700 dark:text-zinc-300 uppercase tracking-wider">Test Case 1 (Publicly Visible)</h4>
                                <div class="grid grid-cols-2 gap-3 mt-2">
                                    <input type="text" name="test_cases_input_1" class="block w-full p-2.5 bg-white dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-xs font-mono" placeholder="Input (e.g. 5, 2)" :required="qType === 'coding'">
                                    <input type="text" name="test_cases_output_1" class="block w-full p-2.5 bg-white dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-xs font-mono" placeholder="Output (e.g. 7)" :required="qType === 'coding'">
                                </div>
                            </div>
                            <div>
                                <h4 class="text-[9px] font-black text-slate-700 dark:text-zinc-300 uppercase tracking-wider">Test Case 2 (Hidden Evaluation)</h4>
                                <div class="grid grid-cols-2 gap-3 mt-2">
                                    <input type="text" name="test_cases_input_2" class="block w-full p-2.5 bg-white dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-xs font-mono" placeholder="Input (e.g. 10, -5)">
                                    <input type="text" name="test_cases_output_2" class="block w-full p-2.5 bg-white dark:bg-zinc-900 border-2 border-black dark:border-zinc-800 rounded-none text-xs font-mono" placeholder="Output (e.g. 5)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d flex items-center justify-center gap-2">
                        Inject Question
                        <i class="fa-solid fa-plus-circle"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Right 2 Columns: List Current Injected Questions -->
        <div class="lg:col-span-2 space-y-6">
            <div class="p-6 border-2 border-black dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-3d min-h-[400px]">
                <h3 class="text-xs font-black uppercase text-slate-950 dark:text-white mb-6 pb-2 border-b border-black/10 dark:border-zinc-800"><i class="fa-solid fa-clipboard-list text-black dark:text-white mr-2"></i>Injected Questions ({{ $exam->questions->count() }})</h3>
                
                @if($exam->questions->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-10 h-10 border border-black dark:border-white bg-slate-50 dark:bg-zinc-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                            <i class="fa-solid fa-folder-open text-base"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Question list empty.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($exam->questions as $index => $q)
                            <div class="p-4 border border-black/15 dark:border-zinc-850 bg-slate-50/50 dark:bg-zinc-950/20 rounded-none shadow-3d-stark">
                                <div class="flex items-center justify-between">
                                    <span class="text-[8px] font-black px-1.5 py-0.5 border border-black uppercase tracking-wider
                                        {{ $q->type === 'coding' ? 'bg-black text-white dark:bg-white dark:text-black' : 'bg-slate-100 text-slate-700 dark:bg-zinc-800 text-black dark:text-white' }}">
                                        {{ $q->type }}
                                    </span>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[9px] font-black text-slate-450 font-mono tracking-wider uppercase">{{ $q->points }} points</span>
                                        <form action="{{ route('organizer.question.delete', [$exam->id, $q->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 transition-colors p-1" title="Delete question">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-800 dark:text-zinc-200 font-extrabold mt-2.5 line-clamp-3 uppercase tracking-wide">
                                    {{ $index + 1 }}. {{ $q->question_text }}
                                </p>
                                
                                @if($q->type === 'mcq' && count($q->options ?? []) > 0)
                                    <div class="mt-3 grid grid-cols-2 gap-1.5 font-bold uppercase tracking-wider text-[9px]">
                                        @foreach($q->options as $oIndex => $opt)
                                            <div class="truncate px-2 py-1 bg-white dark:bg-zinc-900 border border-black/10 dark:border-zinc-800
                                                {{ $oIndex == $q->correct_answer ? 'border-green-500 bg-green-50/20 text-green-700 dark:text-green-400' : 'text-slate-400' }}">
                                                {{ $opt }}
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($q->type === 'coding')
                                    <div class="mt-3 text-[9px] text-slate-400 font-mono flex items-center justify-between font-bold uppercase">
                                        <span><i class="fa-solid fa-vials mr-1"></i>{{ count($q->test_cases ?? []) }} test cases</span>
                                        <span class="text-black dark:text-white"><i class="fa-solid fa-code mr-1"></i>Monaco Sandbox</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
