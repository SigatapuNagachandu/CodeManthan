<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ProctorController;

/*
|--------------------------------------------------------------------------
| Public Landing Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login/otp', [AuthController::class, 'showOtp'])->name('login.otp');
Route::post('/login/otp', [AuthController::class, 'verifyOtp']);

Route::get('/auth/google/select', [AuthController::class, 'showGoogleSelect'])->name('login.google-select');
Route::get('/auth/google/{role}', [AuthController::class, 'mockGoogleLogin'])->name('login.google-mock');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Dashboard Roles Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Notification stream endpoint for real-time candidate warning checks
    Route::get('/candidate/notifications/stream', function() {
        return response()->json(\App\Models\Notification::where('user_id', auth()->id())->get());
    })->name('candidate.notifications-stream');

    // 1. ORGANIZER & SUPER ADMIN PORTAL
    Route::middleware(['role:organizer,super_admin'])->group(function () {
        Route::get('/organizer/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer.dashboard');
        Route::post('/organizer/hackathon', [OrganizerController::class, 'createHackathon'])->name('organizer.hackathon');
        Route::post('/organizer/exam', [OrganizerController::class, 'createExam'])->name('organizer.exam');
        Route::get('/organizer/exam/{id}/builder', [OrganizerController::class, 'examBuilder'])->name('organizer.exam-builder');
        Route::post('/organizer/exam/{id}/question', [OrganizerController::class, 'addQuestion'])->name('organizer.question');
        Route::delete('/organizer/exam/{examId}/question/{questionId}', [OrganizerController::class, 'deleteQuestion'])->name('organizer.question.delete');
        Route::get('/organizer/exam/{id}/monitor', [OrganizerController::class, 'liveMonitor'])->name('organizer.live-monitor');
        Route::get('/organizer/exam/{id}/report', [OrganizerController::class, 'exportReport'])->name('organizer.report-export');
    });

    // 2. CANDIDATE EXAMINATION HUB
    Route::middleware(['role:candidate'])->group(function () {
        Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');
        Route::post('/candidate/hackathon/{id}/register', [CandidateController::class, 'registerHackathon'])->name('candidate.hackathon-register');
        Route::get('/candidate/exam/{id}/room', [CandidateController::class, 'showExamRoom'])->name('candidate.exam-room');
        Route::post('/candidate/exam/{id}/start', [CandidateController::class, 'startExam'])->name('candidate.exam-start');
        Route::get('/candidate/exam/{id}/screen', [CandidateController::class, 'examScreen'])->name('candidate.exam-screen');
        Route::post('/candidate/exam/{id}/autosave', [CandidateController::class, 'saveAnswerProgress'])->name('candidate.exam-autosave');
        Route::post('/candidate/exam/{id}/cheating', [CandidateController::class, 'logCheatingEvent'])->name('candidate.exam-cheating');
        Route::post('/candidate/exam/{id}/submit', [CandidateController::class, 'submitExam'])->name('candidate.exam-submit');
        Route::get('/candidate/exam/{id}/result', [CandidateController::class, 'examResult'])->name('candidate.exam-result');
        Route::post('/candidate/exam/runcode', [CandidateController::class, 'runCodeSnippet'])->name('candidate.exam-runcode');
    });

    // 3. PROCTOR LIVE MONITOR CENTER
    Route::middleware(['role:proctor'])->group(function () {
        Route::get('/proctor/dashboard', [ProctorController::class, 'dashboard'])->name('proctor.dashboard');
        Route::post('/proctor/warn', [ProctorController::class, 'warnCandidate'])->name('proctor.warn');
    });
});
