@extends('layouts.app')

@section('title', 'Security Checkpoint - CodeManthan Security Hub')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Navigation Breadcrumbs -->
    <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase mb-4">
        <a href="{{ route('candidate.dashboard') }}" class="hover:text-black dark:hover:text-white">Candidate Lobby</a>
        <i class="fa-solid fa-chevron-right text-[9px]"></i>
        <span>Security Checkpoint</span>
    </div>

    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-black uppercase tracking-tight text-slate-900 dark:text-white">Security Checkpoint</h1>
        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-zinc-550 mt-1">Configure your camera, audit proctoring constraints, and provide screening consent.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Column 1: Live Hardware Video Diagnostic -->
        <div class="p-6 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white mb-2"><i class="fa-solid fa-camera text-slate-700 dark:text-slate-300 mr-2"></i>Webcam Diagnostics</h3>
                <p class="text-xs font-semibold text-slate-400 dark:text-zinc-550 mb-4 leading-relaxed uppercase tracking-wide">Camera hardware authorization is required to audit identity states.</p>
                
                <!-- Live Video Feed Container -->
                <div class="w-full h-56 bg-zinc-950 border-2 border-black dark:border-zinc-800 flex items-center justify-center overflow-hidden relative shadow-inner">
                    <!-- Placeholder graphic if camera inactive -->
                    <div id="webcamPlaceholder" class="text-center absolute inset-0 flex flex-col items-center justify-center bg-zinc-950 transition-opacity z-10">
                        <div class="w-12 h-12 border border-zinc-850 flex items-center justify-center text-slate-600 mb-3">
                            <i class="fa-solid fa-video-slash"></i>
                        </div>
                        <div class="flex flex-col gap-2 px-6 w-full">
                            <button 
                                type="button"
                                onclick="authorizeWebcam()"
                                class="w-full py-2 bg-white text-black border border-black hover:bg-slate-100 font-bold text-xs uppercase tracking-wider transition-all duration-150">
                                Authorize Webcam
                            </button>
                            <button 
                                type="button"
                                onclick="activateSimulatedCamera()"
                                class="w-full py-2 bg-zinc-900 text-white border border-zinc-800 hover:bg-zinc-800 font-bold text-[10px] uppercase tracking-wider transition-all duration-150">
                                Activate Simulated Camera
                            </button>
                        </div>
                    </div>

                    <!-- Simulated video loop placeholder -->
                    <div id="simulatedCameraOverlay" class="absolute inset-0 flex flex-col items-center justify-center bg-zinc-900 border-2 border-dashed border-violet-500/20 text-center z-20" style="display: none;">
                        <div class="absolute top-2 right-2 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping"></span>
                            <span class="text-[7px] font-mono text-green-500 uppercase tracking-widest">Simulated Feed</span>
                        </div>
                        <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed={{ Auth::user()->name }}" class="w-20 h-20 rounded bg-zinc-800 p-1 opacity-80" alt="Camera Feed">
                        <span class="text-[9px] font-mono text-slate-400 mt-2">Candidate: {{ Auth::user()->name }}</span>
                    </div>

                    <!-- Stream output -->
                    <video 
                        id="webcamStream"
                        autoplay 
                        playsinline 
                        class="w-full h-full object-cover transform scale-x-[-1] opacity-0"></video>
                </div>
            </div>

            <!-- Error banner / Fail-Safe Notifications -->
            <div id="errorMsg" class="mt-4 p-3 border-2 border-black bg-slate-50 dark:bg-zinc-900 text-[10px] text-black dark:text-white font-mono leading-relaxed uppercase tracking-wider" style="display: none;">
                <i class="fa-solid fa-info-circle mr-1 text-xs"></i> <span id="errorMsgText"></span>
            </div>
        </div>

        <!-- Column 2: Legal rules & Consent checklist -->
        <div class="p-6 border-2 border-black dark:border-white bg-white dark:bg-black shadow-3d flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-black uppercase text-slate-950 dark:text-white mb-2"><i class="fa-solid fa-shield-halved text-slate-700 dark:text-slate-300 mr-2"></i>Screening Consent</h3>
                <p class="text-xs font-semibold text-slate-400 dark:text-zinc-550 mb-6 leading-relaxed uppercase tracking-wide">Review and accept proctor tracking criteria to start the exam.</p>

                <!-- Checkboxes -->
                <div class="space-y-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="consentFullscreen" class="mt-0.5 rounded-none border-2 border-black dark:border-zinc-700 text-black focus:ring-0 w-4 h-4 shrink-0">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-zinc-400 select-none leading-normal">
                            I authorize full-screen mode locking and exit logging.
                        </div>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="consentWebcam" disabled class="mt-0.5 rounded-none border-2 border-black dark:border-zinc-700 text-black focus:ring-0 w-4 h-4 shrink-0">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-zinc-400 select-none leading-normal">
                            I consent to webcam snapshot surveillance. *(Requires Authorized or Simulated camera)*
                        </div>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="consentLock" class="mt-0.5 rounded-none border-2 border-black dark:border-zinc-700 text-black focus:ring-0 w-4 h-4 shrink-0">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-zinc-400 select-none leading-normal">
                            I accept right-click and clipboard restriction rules.
                        </div>
                    </label>
                </div>
            </div>

            <!-- Launch trigger button -->
            <div class="mt-6 pt-6 border-t border-black dark:border-zinc-800">
                <form action="{{ route('candidate.exam-start', $exam->id) }}" method="POST">
                    @csrf
                    <button 
                        type="submit" 
                        id="sitExamButton"
                        disabled
                        class="w-full py-4 bg-black dark:bg-white text-white dark:text-black border-2 border-black dark:border-white font-extrabold uppercase tracking-widest text-xs opacity-30 cursor-not-allowed flex items-center justify-center gap-2 transition-all duration-150">
                        Sit for Screening Exam
                        <i class="fa-solid fa-circle-chevron-right text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Authorize Webcam hardware
    function authorizeWebcam() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                let video = document.getElementById('webcamStream');
                video.srcObject = stream;
                video.classList.remove('opacity-0');
                document.getElementById('webcamPlaceholder').style.display = 'none';
                
                // Enable and check webcam consent
                let check = document.getElementById('consentWebcam');
                check.disabled = false;
                check.checked = true;
                
                validateConsent();
            }).catch(err => {
                showDiagnosticError('Hardware webcam blocked or busy. Activating Virtual Camera Simulator.');
                activateSimulatedCamera();
            });
        } else {
            showDiagnosticError('Browser media API unsupported or insecure HTTP. Activating Virtual Camera Simulator.');
            activateSimulatedCamera();
        }
    }

    // 2. Activate Simulated Camera
    function activateSimulatedCamera() {
        document.getElementById('simulatedCameraOverlay').style.display = 'flex';
        document.getElementById('webcamPlaceholder').style.display = 'none';
        
        let check = document.getElementById('consentWebcam');
        check.disabled = false;
        check.checked = true;
        
        showDiagnosticError('CodeManthan Virtual Camera Feed Enabled (Local Testing Bypassed).');
        validateConsent();
    }

    // 3. Helper to show diagnostics notices
    function showDiagnosticError(msg) {
        document.getElementById('errorMsgText').innerText = msg;
        document.getElementById('errorMsg').style.display = 'block';
    }

    // 4. Validate checkboxes state and release sitting button
    function validateConsent() {
        let f = document.getElementById('consentFullscreen').checked;
        let w = document.getElementById('consentWebcam').checked;
        let l = document.getElementById('consentLock').checked;
        let btn = document.getElementById('sitExamButton');

        if (f && w && l) {
            btn.disabled = false;
            btn.classList.remove('opacity-30', 'cursor-not-allowed');
            btn.classList.add('shadow-3d');
        } else {
            btn.disabled = true;
            btn.classList.add('opacity-30', 'cursor-not-allowed');
            btn.classList.remove('shadow-3d');
        }
    }

    // Bind event listeners for vanilla checkboxes
    document.getElementById('consentFullscreen').addEventListener('change', validateConsent);
    document.getElementById('consentWebcam').addEventListener('change', validateConsent);
    document.getElementById('consentLock').addEventListener('change', validateConsent);
</script>
@endsection
