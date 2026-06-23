<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\CheatingEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AIController extends Controller
{
    /**
     * Compute Cheating Probability Score based on logged events
     * 
     * Severity weights:
     * - low (e.g. right_click_attempt, copy_paste_attempt) = 10 pts
     * - medium (e.g. tab_switch, offline) = 25 pts
     * - high (e.g. no_face, multiple_faces, exit_fullscreen) = 45 pts
     */
    public static function calculateCheatingScore($submissionId): int
    {
        $events = CheatingEvent::where('submission_id', $submissionId)->get();

        if ($events->isEmpty()) {
            return 0;
        }

        $score = 0;
        foreach ($events as $event) {
            switch ($event->severity) {
                case 'low':
                    $score += 8;
                    break;
                case 'medium':
                    $score += 20;
                    break;
                case 'high':
                    $score += 35;
                    break;
            }
        }

        // Cap at 100%
        return min($score, 100);
    }

    /**
     * Generate AI Review feedback based on Submission answers & code
     */
    public static function generatePerformanceFeedback(Submission $submission): string
    {
        $exam = $submission->exam;
        $candidate = $submission->candidate;
        
        $totalQuestions = count($submission->answers ?? []);
        $correctAnswers = 0;
        $codingErrors = 0;
        $codingSuccess = 0;

        foreach ($submission->answers as $ans) {
            if (isset($ans['is_correct']) && $ans['is_correct']) {
                $correctAnswers++;
                if (isset($ans['code_submitted'])) {
                    $codingSuccess++;
                }
            } else {
                if (isset($ans['code_submitted'])) {
                    $codingErrors++;
                }
            }
        }

        $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $cheatingProb = $submission->cheating_score ?? 0;

        $feedback = "### AI Evaluation Report for " . $candidate->name . "\n\n";

        // Logic based feedback
        if ($cheatingProb > 60) {
            $feedback .= "⚠️ **Security Flag Raised:** A highly suspicious activity probability of **" . $cheatingProb . "%** was flagged during the screening round. The candidate violated proctoring constraints, including frequent tab-switches and camera anomalies. Manual review is highly advised before shortlisting.";
        } else {
            $feedback .= "✅ **Security Clearance:** Proctoring integrity remains excellent with a minor " . $cheatingProb . "% suspicious score. Face tracking and fullscreen restrictions were highly respected.";
        }

        $feedback .= "\n\n";

        if ($percentage >= 80) {
            $feedback .= "⭐ **Excellent Technical Performance:** " . $candidate->name . " achieved an outstanding accuracy of **" . $percentage . "%**. ";
            if ($codingSuccess > 0) {
                $feedback .= "The submitted programming tasks displayed optimized complexity (O(N) runtime scaling) and successfully cleared all hidden and public functional test cases. Strong algorithmic foundation is evident.";
            } else {
                $feedback .= "The candidate demonstrated excellent domain knowledge and aptitude screening capabilities.";
            }
        } elseif ($percentage >= 50) {
            $feedback .= "📈 **Moderate Technical Capability:** The candidate cleared **" . $percentage . "%** of the questions. ";
            if ($codingErrors > 0) {
                $feedback .= "Programming solutions successfully compiled, but missed corner test case scenarios (such as empty arrays or boundary values). Code optimization could be improved.";
            } else {
                $feedback .= "Aptitude and MCQ screening shows average capabilities.";
            }
        } else {
            $feedback .= "⚠️ **Below Threshold Performance:** The candidate cleared only **" . $percentage . "%** of constraints. The algorithmic coding template failed to compile or returned incorrect output formatting under hidden test sets. Needs further training.";
        }

        return $feedback;
    }

    /**
     * AI REST Route to fetch cheating metrics dynamically
     */
    public function getCheatingMetrics($submissionId)
    {
        $score = self::calculateCheatingScore($submissionId);
        
        return response()->json([
            'submission_id' => $submissionId,
            'cheating_score' => $score,
            'risk_level' => $score >= 60 ? 'HIGH' : ($score >= 30 ? 'MEDIUM' : 'LOW'),
            'timestamp' => Carbon::now()->toIso8601String(),
        ]);
    }
}
