@extends('layouts.app')

@section('title', 'Exam Console - CodeManthan Security Hub')

@section('content')
<!-- High Priority Warnings Alert Banner -->
<div id="proctor-warning-banner" class="hidden fixed top-16 inset-x-0 z-50 bg-black dark:bg-white text-white dark:text-black text-center py-3.5 px-6 text-xs font-black uppercase tracking-widest animate-bounce flex items-center justify-center gap-3 border-b-2 border-black dark:border-white shadow-2xl">
    <i class="fa-solid fa-triangle-exclamation text-base"></i>
    <span id="proctor-warning-text">WARNING: SUSPICIOUS ACTIVITY LOGGED BY AI. PROCTOR WARNING DISPATCHED.</span>
    <button onclick="document.getElementById('proctor-warning-banner').classList.add('hidden')" class="bg-white/20 dark:bg-black/20 text-white dark:text-black px-2.5 py-1 text-[10px] font-bold hover:bg-white/40">Dismiss</button>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="examConsole">

    <div class="grid lg:grid-cols-4 gap-8">
        
        <!-- Left Side: Webcam, Compliance, Timer, Navigation (1/4 Width) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Visual Webcam & Compliance Box -->
            <div class="p-5 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Visual Proctor Stream</h3>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                        <span class="text-[8px] font-black text-rose-600 uppercase tracking-wider">Audit</span>
                    </div>
                </div>

                <!-- Live/Simulated Webcam Box -->
                <div class="w-full h-36 bg-zinc-950 border-2 border-black dark:border-zinc-800 rounded-none overflow-hidden relative shadow-inner mb-4 flex items-center justify-center">
                    <video id="proctorWebcam" autoplay playsinline class="w-full h-full object-cover transform scale-x-[-1]"></video>
                    
                    <!-- Simulated feed overlay if getuserMedia blocks -->
                    <div x-show="cameraSimulated" class="absolute inset-0 flex flex-col items-center justify-center bg-zinc-900 border-2 border-dashed border-violet-500/20 text-center z-15">
                        <div class="absolute top-2 right-2 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-ping"></span>
                            <span class="text-[7px] font-mono text-violet-500 uppercase tracking-widest">Simulated</span>
                        </div>
                        <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed={{ Auth::user()->name }}" class="w-12 h-12 rounded bg-zinc-800 p-1 opacity-80" alt="Camera Feed">
                        <span class="text-[8px] font-mono text-slate-400 mt-1.5 truncate max-w-[120px]">Candidate: {{ Auth::user()->name }}</span>
                    </div>
                </div>

                <div class="text-center bg-slate-50 dark:bg-zinc-900/50 p-3 rounded-none border border-black/40 dark:border-zinc-800">
                    <span id="compliance-meter" class="text-[10px] font-black text-slate-700 dark:text-zinc-300 uppercase tracking-wider">
                        0% Suspicion Score
                    </span>
                    <p class="text-[9px] text-slate-400 leading-normal mt-1"><i class="fa-solid fa-face-smile text-emerald-500 mr-1"></i>Webcam Compliance Green</p>
                </div>
            </div>

            <!-- Countdown Timer Card -->
            <div class="p-5 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d text-center">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Time Remaining</span>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1.5 font-mono" x-text="formatTime()"></h2>
            </div>

            <!-- Question Navigation Grid -->
            <div class="p-5 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Question Navigator</h3>
                
                <div class="grid grid-cols-4 gap-2">
                    <template x-for="(q, idx) in questions" :key="idx">
                        <button 
                            @click="
                                if(questions[activeQ].type === 'coding' && window.monacoEditor) {
                                    answersSheet[activeQ].code_submitted = window.monacoEditor.getValue();
                                }
                                activeQ = idx;
                                if(q.type === 'coding') {
                                    setTimeout(() => {
                                        if (window.monacoEditor) {
                                            window.monacoEditor.setValue(answersSheet[idx].code_submitted || q.coding_template.python);
                                            window.monacoEditor.layout();
                                        }
                                    }, 100);
                                }
                            "
                            :class="activeQ === idx ? 'bg-black text-white dark:bg-white dark:text-black border-2 border-black dark:border-white' : 
                                (answersSheet[idx] && (answersSheet[idx].selected_option || answersSheet[idx].code_submitted) ? 'bg-slate-100 dark:bg-zinc-900 text-black dark:text-white border border-black dark:border-zinc-800 font-black' : 'bg-slate-50 dark:bg-zinc-950 border border-slate-200 dark:border-zinc-850 text-slate-400')"
                            class="py-3 text-xs font-black rounded-none transition-all duration-150 shadow-3d-stark"
                            x-text="idx + 1"></button>
                    </template>
                </div>
            </div>

            <!-- Direct Submission Form wrapper -->
            <form id="exam-submission-form" action="{{ route('candidate.exam-submit', $exam->id) }}" method="POST">
                @csrf
                <input type="hidden" name="answers" :value="JSON.stringify(answersSheet)">
                <input type="hidden" name="duration_taken_seconds" :value="{{ $exam->duration_minutes * 60 }} - timerSeconds">
                
                <button 
                    type="submit" 
                    @click="
                        if(questions[activeQ].type === 'coding' && window.monacoEditor) {
                            answersSheet[activeQ].code_submitted = window.monacoEditor.getValue();
                        }
                    "
                    class="w-full py-4 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d flex items-center justify-center gap-2">
                    Submit Screen sheet
                    <i class="fa-solid fa-circle-check"></i>
                </button>
            </form>
        </div>

        <!-- Right Side: Screening Question console & Monaco Workspace (3/4 Width) -->
        <div class="lg:col-span-3 space-y-6">
            <div class="p-6 sm:p-8 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d min-h-[450px] flex flex-col justify-between">
                
                <!-- Question Header info -->
                <div>
                    <div class="flex items-center justify-between gap-4 pb-4 border-b-2 border-black dark:border-zinc-800">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase">Question <span x-text="activeQ + 1"></span> of <span x-text="questions.length"></span></span>
                            <span class="text-[9px] font-black px-1.5 py-0.5 border border-black dark:border-white bg-black dark:bg-white text-white dark:text-black uppercase tracking-widest animate-pulse" x-text="questions[activeQ].type"></span>
                        </div>
                        <div class="flex items-center gap-3 text-[10px] font-black text-slate-400">
                            <span class="font-mono text-black dark:text-white uppercase tracking-wider" x-text="questions[activeQ].points + ' Points'"></span>
                        </div>
                    </div>

                    <!-- Question Prompt content -->
                    <div class="mt-6">
                        <p class="text-base font-bold text-slate-900 dark:text-white leading-relaxed" x-text="questions[activeQ].question_text"></p>
                    </div>

                    <!-- MCQ OPTIONS RENDER CARD (Show if active question is mcq or aptitude) -->
                    <div class="mt-8 space-y-3" x-show="questions[activeQ].type === 'mcq' || questions[activeQ].type === 'aptitude'">
                        <template x-for="(opt, oIdx) in questions[activeQ].options" :key="oIdx">
                            <label 
                                @click="answersSheet[activeQ].selected_option = oIdx; triggerAutosave();"
                                :class="answersSheet[activeQ].selected_option == oIdx ? 'border-black dark:border-white bg-slate-50 dark:bg-zinc-900 text-black dark:text-white font-extrabold shadow-3d-stark' : 'border-slate-200 dark:border-zinc-800'"
                                class="flex items-center gap-3.5 p-4 rounded-none border-2 hover:bg-slate-50 dark:hover:bg-zinc-900 transition-all cursor-pointer">
                                <input 
                                    type="radio" 
                                    :name="'q_' + activeQ" 
                                    :checked="answersSheet[activeQ].selected_option == oIdx"
                                    class="text-black focus:ring-0 w-4 h-4 shrink-0">
                                <span class="text-xs font-bold uppercase tracking-wider select-none" x-text="opt"></span>
                            </label>
                        </template>
                    </div>

                    <!-- MONACO WORKSPACE RENDER PANEL (Show if active question is coding) -->
                    <div class="mt-8 space-y-4" x-show="questions[activeQ].type === 'coding'">
                        <div class="flex items-center justify-between p-2 bg-slate-100 dark:bg-zinc-950 border border-black dark:border-zinc-800 rounded-none">
                            <div class="flex items-center gap-2">
                                <span class="text-[9px] font-black text-slate-450 uppercase pl-2">Select Language</span>
                                <select 
                                    x-model="activeLanguage" 
                                    @change="
                                        let selectedTemplate = questions[activeQ].coding_template[activeLanguage] || '';
                                        if (window.monacoEditor) {
                                            window.monacoEditor.setValue(selectedTemplate);
                                        } else {
                                            answersSheet[activeQ].code_submitted = selectedTemplate;
                                        }
                                        answersSheet[activeQ].language = activeLanguage;
                                    "
                                    class="bg-white dark:bg-zinc-900 border border-black dark:border-zinc-850 text-xs font-black text-slate-700 dark:text-zinc-200 px-3 py-1">
                                    <option value="python">Python 3</option>
                                    <option value="javascript">JavaScript</option>
                                </select>
                            </div>
                            <button 
                                @click="runCodeCompiler()" 
                                :disabled="compiling"
                                class="px-4 py-2 bg-black dark:bg-white text-white dark:text-black border border-black dark:border-white font-extrabold uppercase tracking-widest text-[10px] shadow-3d-stark transition-all flex items-center gap-1.5 disabled:opacity-50">
                                <i class="fa-solid" :class="compiling ? 'fa-spinner animate-spin' : 'fa-play'"></i>
                                Run Snippet
                            </button>
                        </div>

                        <!-- Monaco Editor Mounted DIV -->
                        <div class="w-full h-80 border-2 border-black dark:border-zinc-800 bg-[#1e1e1e] relative">
                            <div id="monaco-container" x-show="monacoLoaded" class="w-full h-full"></div>
                            <textarea 
                                x-show="!monacoLoaded" 
                                x-model="answersSheet[activeQ].code_submitted"
                                class="w-full h-full bg-zinc-950 text-slate-200 font-mono p-4 border-0 focus:ring-0 resize-none text-xs" 
                                placeholder="Type your coding solution here... (Standard Editor Fallback)"></textarea>
                        </div>

                        <!-- Compiler Output Drawer -->
                        <div class="border-2 border-black dark:border-zinc-800 bg-slate-50 dark:bg-zinc-950 p-5 font-mono text-[10px] uppercase tracking-wider">
                            <div class="flex items-center justify-between pb-3 border-b border-black/10 dark:border-zinc-850 mb-3">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Compiler Sandbox Output</span>
                                <div class="flex items-center gap-2" x-show="compileStatus">
                                    <span :class="compileStatus === 'Passed' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-400' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-400'" class="text-[8px] font-black px-1.5 py-0.5 border border-black uppercase" x-text="compileStatus"></span>
                                    <span class="text-[8px] text-slate-400 font-bold" x-text="compileRuntime + 'ms / ' + compileMemory + 'KB'"></span>
                                </div>
                            </div>
                            <pre class="overflow-x-auto text-slate-700 dark:text-zinc-400 max-h-28 text-[10px] font-mono leading-relaxed normal-case" x-text="compileOutput || 'Ready to run snippet...'"></pre>
                        </div>
                    </div>
                </div>

                <!-- Footer Nav Button block -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t-2 border-black dark:border-zinc-800">
                    <button 
                        @click="
                            if(questions[activeQ].type === 'coding' && window.monacoEditor) {
                                answersSheet[activeQ].code_submitted = window.monacoEditor.getValue();
                            }
                            activeQ = Math.max(0, activeQ - 1);
                            if(questions[activeQ].type === 'coding') {
                                setTimeout(() => {
                                    if (window.monacoEditor) {
                                        window.monacoEditor.setValue(answersSheet[activeQ].code_submitted || questions[activeQ].coding_template.python);
                                        window.monacoEditor.layout();
                                    }
                                }, 100);
                            }
                        "
                        :disabled="activeQ === 0"
                        class="px-4 py-2.5 border-2 border-black dark:border-zinc-800 text-slate-700 dark:text-zinc-300 font-bold text-xs hover:bg-slate-50 transition-colors disabled:opacity-30">
                        <i class="fa-solid fa-arrow-left mr-1.5"></i>Prev Question
                    </button>

                    <button 
                        @click="
                            if(questions[activeQ].type === 'coding' && window.monacoEditor) {
                                answersSheet[activeQ].code_submitted = window.monacoEditor.getValue();
                            }
                            activeQ = Math.min(questions.length - 1, activeQ + 1);
                            if(questions[activeQ].type === 'coding') {
                                setTimeout(() => {
                                    if (window.monacoEditor) {
                                        window.monacoEditor.setValue(answersSheet[activeQ].code_submitted || questions[activeQ].coding_template.python);
                                        window.monacoEditor.layout();
                                    }
                                }, 100);
                            }
                        "
                        :disabled="activeQ === questions.length - 1"
                        class="px-4 py-2.5 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs hover:-translate-x-0.5 hover:-translate-y-0.5 transition-all shadow-3d-stark disabled:opacity-30">
                        Next Question<i class="fa-solid fa-arrow-right ml-1.5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Alpine.js Component Definition -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('examConsole', () => ({
            activeQ: 0,
            questions: {!! json_encode($exam->questions) !!},
            answersSheet: [],
            timerSeconds: {{ $exam->duration_minutes * 60 - ($submission->duration_taken_seconds ?? 0) }},
            activeLanguage: 'python',
            compileStatus: '',
            compileOutput: '',
            compileRuntime: '',
            compileMemory: '',
            compileResults: [],
            compiling: false,
            cameraSimulated: false,
            monacoLoaded: false,

            init() {
                // Hydrate answer sheet
                let loaded = {!! json_encode($submission->answers ?? []) !!};
                this.questions.forEach((q, idx) => {
                    let found = loaded.find(a => a.question_id == q._id);
                    this.answersSheet.push({
                        question_id: q._id,
                        selected_option: found ? found.selected_option : null,
                        code_submitted: found ? found.code_submitted : (q.coding_template ? q.coding_template.python : ''),
                        language: found ? found.language : 'python'
                    });
                });

                // Initialize countdown clock
                setInterval(() => {
                    if (this.timerSeconds > 0) {
                        this.timerSeconds--;
                        if (this.timerSeconds === 0) {
                            this.autoCommitExam();
                        }
                    }
                }, 1000);

                // Progressive Background Autosave
                setInterval(() => {
                    this.triggerAutosave();
                }, 10000);

                // Fetch Proctor Warnings
                setInterval(() => {
                    fetch('{{ route('candidate.notifications-stream') }}')
                    .then(r => r.json())
                    .then(data => {
                        let urgent = data.find(n => n.type === 'cheating_warning' && !n.is_read);
                        if (urgent) {
                            document.getElementById('proctor-warning-banner').classList.remove('hidden');
                            document.getElementById('proctor-warning-text').innerText = '🚨 PROCTOR MESSAGE: ' + urgent.message;
                        }
                    });
                }, 8000);
            },

            formatTime() {
                let hrs = Math.floor(this.timerSeconds / 3600);
                let mins = Math.floor((this.timerSeconds % 3600) / 60);
                let secs = this.timerSeconds % 60;
                return (hrs > 0 ? hrs + ':' : '') + (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
            },

            triggerAutosave() {
                fetch('{{ route('candidate.exam-autosave', $exam->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        answers: this.answersSheet,
                        duration_taken_seconds: {{ $exam->duration_minutes * 60 }} - this.timerSeconds
                    })
                }).then(r => r.json()).then(data => {
                    console.log('Progress Sync Complete:', data.last_sync);
                });
            },

            logAntiCheat(type, severity) {
                fetch('{{ route('candidate.exam-cheating', $exam->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ event_type: type, severity: severity })
                }).then(r => r.json()).then(data => {
                    let meter = document.getElementById('compliance-meter');
                    if (meter) {
                        meter.innerText = data.cheating_score + '% Suspicion';
                    }
                });
            },

            runCodeCompiler() {
                this.compiling = true;
                this.compileStatus = 'Compiling...';
                this.compileOutput = '';
                this.compileResults = [];

                let currentCode = '';
                if (window.monacoEditor) {
                    currentCode = window.monacoEditor.getValue();
                } else {
                    currentCode = this.answersSheet[this.activeQ].code_submitted || '';
                }
                this.answersSheet[this.activeQ].code_submitted = currentCode;
                this.answersSheet[this.activeQ].language = this.activeLanguage;

                fetch('{{ route('candidate.exam-runcode') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        code: currentCode,
                        language: this.activeLanguage,
                        question_id: this.questions[this.activeQ]._id
                    })
                }).then(r => r.json()).then(data => {
                    this.compiling = false;
                    this.compileStatus = data.status;
                    this.compileOutput = data.stdout;
                    this.compileRuntime = data.runtime_ms;
                    this.compileMemory = data.memory_kb;
                    this.compileResults = data.results;
                }).catch(err => {
                    console.error('Compiler execution failed:', err);
                    this.compiling = false;
                    this.compileStatus = 'Error';
                    this.compileOutput = 'Execution failed: Network or sandbox timeout.';
                });
            },

            autoCommitExam() {
                alert('Time elapsed! Submitting assessment sheet.');
                document.getElementById('exam-submission-form').submit();
            }
        }));
    });
</script>

<!-- Monaco Editor Loader Scripts -->
<script>
    var require = { paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs' } };
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs/loader.min.js"></script>
<script>
    require(['vs/editor/editor.main'], function() {
        let defaultCode = `def twoSum(nums, target):\n    # Write your Python 3 code here\n    pass`;
        
        let consoleEl = document.querySelector('[x-data]');
        if (consoleEl && consoleEl._x_dataStack) {
            let data = consoleEl._x_dataStack[0];
            if (data.questions[data.activeQ] && data.questions[data.activeQ].type === 'coding') {
                defaultCode = data.answersSheet[data.activeQ].code_submitted || (data.questions[data.activeQ].coding_template ? data.questions[data.activeQ].coding_template.python : defaultCode);
            }
        } else if (consoleEl && consoleEl.__x) {
            let data = consoleEl.__x.$data;
            if (data.questions[data.activeQ] && data.questions[data.activeQ].type === 'coding') {
                defaultCode = data.answersSheet[data.activeQ].code_submitted || (data.questions[data.activeQ].coding_template ? data.questions[data.activeQ].coding_template.python : defaultCode);
            }
        }

        window.monacoEditor = monaco.editor.create(document.getElementById('monaco-container'), {
            value: defaultCode,
            language: 'python',
            theme: 'vs-dark',
            automaticLayout: true,
            minimap: { enabled: false },
            fontSize: 13,
            lineHeight: 18,
            fontFamily: 'Consolas, monospace',
            roundedSelection: true,
            scrollBeyondLastLine: false,
            cursorBlinking: 'smooth'
        });

        // Toggle Alpine monacoLoaded state to true
        if (consoleEl && consoleEl._x_dataStack) {
            consoleEl._x_dataStack[0].monacoLoaded = true;
        } else if (consoleEl && consoleEl.__x) {
            consoleEl.__x.$data.monacoLoaded = true;
        }
    });
</script>

<!-- Security Proctoring Enforcement scripts -->
<script>
    window.addEventListener('load', () => {
        // Try to spin up live camera
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            document.getElementById('proctorWebcam').srcObject = stream;
        }).catch(err => {
            console.warn('Camera blocked locally. Activating simulated video feed.');
            // Toggle Alpine state simulatedCamera inside context
            let consoleEl = document.querySelector('[x-data]');
            if (consoleEl && consoleEl._x_dataStack) {
                consoleEl._x_dataStack[0].cameraSimulated = true;
            } else if (consoleEl && consoleEl.__x) {
                consoleEl.__x.$data.cameraSimulated = true;
            }
        });

        // Exit Fullscreen monitoring
        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                alert('🚨 HIGH-PRIORITY PROCTOR BREACH: EXITED FULLSCREEN! Incident logged.');
                let consoleEl = document.querySelector('[x-data]');
                if (consoleEl && consoleEl._x_dataStack) {
                    consoleEl._x_dataStack[0].logAntiCheat('exit_fullscreen', 'high');
                } else if (consoleEl && consoleEl.__x) {
                    consoleEl.__x.$data.logAntiCheat('exit_fullscreen', 'high');
                }
            }
        });

        // Tab Switching monitoring
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                alert('🚨 PROCTOR ALERT: BROWSER TAB SWITCH DETECTED!');
                let consoleEl = document.querySelector('[x-data]');
                if (consoleEl && consoleEl._x_dataStack) {
                    consoleEl._x_dataStack[0].logAntiCheat('tab_switch', 'medium');
                } else if (consoleEl && consoleEl.__x) {
                    consoleEl.__x.$data.logAntiCheat('tab_switch', 'medium');
                }
            }
        });

        // Block context clicks
        document.addEventListener('contextmenu', (event) => {
            event.preventDefault();
            alert('🚨 Context Menu (Right Click) is disabled during the exam.');
            let consoleEl = document.querySelector('[x-data]');
            if (consoleEl && consoleEl._x_dataStack) {
                consoleEl._x_dataStack[0].logAntiCheat('right_click_attempt', 'low');
            } else if (consoleEl && consoleEl.__x) {
                consoleEl.__x.$data.logAntiCheat('right_click_attempt', 'low');
            }
        });

        // Block copy shortcuts
        document.addEventListener('keydown', (event) => {
            if (event.ctrlKey && (event.key === 'c' || event.key === 'v' || event.key === 'x')) {
                event.preventDefault();
                alert('🚨 Clipboard copying and pasting is strictly disabled.');
                let consoleEl = document.querySelector('[x-data]');
                if (consoleEl && consoleEl._x_dataStack) {
                    consoleEl._x_dataStack[0].logAntiCheat('copy_paste_attempt', 'low');
                } else if (consoleEl && consoleEl.__x) {
                    consoleEl.__x.$data.logAntiCheat('copy_paste_attempt', 'low');
                }
            }
        });
    });
</script>
@endsection
