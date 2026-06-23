<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Exam;
use App\Models\Submission;
use App\Models\CheatingEvent;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProctorController extends Controller
{
    /**
     * Proctor Live Monitor Dashboard
     */
    public function dashboard()
    {
        // Fetch all exams that have submissions in progress or recently submitted
        $exams = Exam::with('hackathon')->get();
        
        // Fetch active violations logged
        $violations = CheatingEvent::with('candidate', 'submission.exam')
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        // Active candidates details
        $activeSubmissions = Submission::where('status', 'in_progress')
            ->with('candidate', 'exam.hackathon')
            ->get();

        return view('proctor.dashboard', compact('exams', 'violations', 'activeSubmissions'));
    }

    /**
     * Dispatch Warning Alert to Candidate Screen
     */
    public function warnCandidate(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|string',
            'message' => 'required|string|max:500'
        ]);

        $candidateId = $request->candidate_id;
        $message = $request->message;

        // Save a high-priority proctor warning in notifications collection
        Notification::create([
            'user_id' => $candidateId,
            'title' => '🚨 URGENT PROCTOR WARNING!',
            'message' => $message,
            'is_read' => false,
            'type' => 'cheating_warning'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Warning broadcasted to candidate console successfully.'
        ]);
    }
}
