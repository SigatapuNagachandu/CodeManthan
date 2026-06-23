<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hackathon;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Submission;
use App\Models\CheatingEvent;
use App\Models\ProctorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrganizerController extends Controller
{
    /**
     * Organizer Dashboard
     */
    public function dashboard()
    {
        $organizerId = Auth::id();
        $hackathons = Hackathon::where('organizer_id', $organizerId)->with('exams')->get();
        
        $examIds = [];
        foreach ($hackathons as $hack) {
            foreach ($hack->exams as $ex) {
                $examIds[] = $ex->id;
            }
        }

        $totalHackathons = $hackathons->count();
        $totalExams = count($examIds);

        // Submissions statistics
        $submissions = Submission::whereIn('exam_id', $examIds)->with('candidate')->get();
        $totalSubmissions = $submissions->count();
        $averageCheatingScore = $submissions->avg('cheating_score') ?? 0;
        
        // Count active candidates (in_progress submissions)
        $liveCandidates = Submission::whereIn('exam_id', $examIds)->where('status', 'in_progress')->count();

        // Cheating events breakdown
        $recentEvents = CheatingEvent::whereIn('submission_id', $submissions->pluck('id'))->with('candidate', 'submission.exam')->orderBy('created_at', 'desc')->take(6)->get();

        // Chart.js Mock datasets for premium rendering
        $chartsData = [
            'submissionLabels' => ['May 22', 'May 23', 'May 24', 'May 25', 'May 26', 'May 27'],
            'submissionValues' => [5, 12, 19, 25, 32, $totalSubmissions],
            'cheatingLabels' => ['Clean', 'Low Alert (1-29%)', 'Moderate (30-59%)', 'High Suspect (60%+)'],
            'cheatingValues' => [
                $submissions->where('cheating_score', '<', 5)->count(),
                $submissions->where('cheating_score', '>=', 5)->where('cheating_score', '<', 30)->count(),
                $submissions->where('cheating_score', '>=', 30)->where('cheating_score', '<', 60)->count(),
                $submissions->where('cheating_score', '>=', 60)->count()
            ],
            'difficultyDistribution' => [
                'easy' => Question::whereIn('exam_id', $examIds)->where('difficulty', 'easy')->count(),
                'medium' => Question::whereIn('exam_id', $examIds)->where('difficulty', 'medium')->count(),
                'hard' => Question::whereIn('exam_id', $examIds)->where('difficulty', 'hard')->count()
            ]
        ];

        return view('organizer.dashboard', compact(
            'hackathons',
            'totalHackathons',
            'totalExams',
            'totalSubmissions',
            'averageCheatingScore',
            'liveCandidates',
            'recentEvents',
            'chartsData'
        ));
    }

    /**
     * Create a New Hackathon
     */
    public function createHackathon(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|url',
        ]);

        $data['organizer_id'] = Auth::id();
        $data['banner_image'] = $data['banner_image'] ?: 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80';
        $data['status'] = 'active';

        Hackathon::create($data);

        return redirect()->route('organizer.dashboard')->with('success', 'Hackathon "' . $data['title'] . '" created successfully!');
    }

    /**
     * Create a New Exam under a Hackathon
     */
    public function createExam(Request $request)
    {
        $data = $request->validate([
            'hackathon_id' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_minutes' => 'required|integer|min:5|max:480',
        ]);

        $data['rules'] = [
            'Do not switch browser tabs or exit fullscreen mode. Doing so creates visual alert logs.',
            'The webcam stream is checked periodically. Only one face should be visible at all times.',
            'Right-click and text copy-pasting is strictly disabled.',
            'Answers are autosaved progressively.'
        ];

        $data['anti_cheating'] = [
            'webcam_required' => true,
            'block_tab_switch' => true,
            'enforce_fullscreen' => true,
            'block_copy_paste' => true,
        ];

        $exam = Exam::create($data);

        return redirect()->route('organizer.exam-builder', $exam->id)->with('success', 'Exam "' . $data['title'] . '" initialized! You can now add screening questions.');
    }

    /**
     * Show Exam Builder Portal
     */
    public function examBuilder($examId)
    {
        $exam = Exam::with('hackathon', 'questions')->findOrFail($examId);
        return view('organizer.exam-builder', compact('exam'));
    }

    /**
     * Add Question to Exam
     */
    public function addQuestion(Request $request, $examId)
    {
        $request->validate([
            'type' => 'required|in:mcq,coding,aptitude',
            'question_text' => 'required|string',
            'points' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,medium,hard',
            // MCQ attributes
            'options' => 'required_if:type,mcq,aptitude|nullable|array|min:2',
            'correct_answer' => 'required_if:type,mcq,aptitude|nullable|string',
            // Coding attributes
            'coding_template_python' => 'required_if:type,coding|nullable|string',
            'coding_template_javascript' => 'required_if:type,coding|nullable|string',
            'test_cases_input_1' => 'required_if:type,coding|nullable|string',
            'test_cases_output_1' => 'required_if:type,coding|nullable|string',
        ]);

        $data = [
            'exam_id' => $examId,
            'type' => $request->type,
            'question_text' => $request->question_text,
            'points' => (int) $request->points,
            'difficulty' => $request->difficulty,
        ];

        if ($request->type === 'mcq' || $request->type === 'aptitude') {
            $data['options'] = array_values(array_filter($request->options));
            $data['correct_answer'] = $request->correct_answer;
        } elseif ($request->type === 'coding') {
            $data['coding_template'] = [
                'python' => $request->coding_template_python,
                'javascript' => $request->coding_template_javascript,
                'php' => "function solve() {\n    // Write code here\n}"
            ];

            // Build test cases
            $data['test_cases'] = [
                [
                    'input' => $request->test_cases_input_1,
                    'output' => $request->test_cases_output_1,
                    'is_hidden' => false
                ]
            ];

            if ($request->filled('test_cases_input_2')) {
                $data['test_cases'][] = [
                    'input' => $request->test_cases_input_2,
                    'output' => $request->test_cases_output_2,
                    'is_hidden' => true
                ];
            }
        }

        Question::create($data);

        return back()->with('success', 'Question injected into exam successfully!');
    }

    /**
     * Live Exam Monitor Widget
     */
    public function liveMonitor($examId)
    {
        $exam = Exam::with('hackathon')->findOrFail($examId);
        $submissions = Submission::where('exam_id', $examId)->with('candidate')->get();

        return view('organizer.live-monitor', compact('exam', 'submissions'));
    }

    /**
     * Export beautiful HTML PDF Report (Print Friendly)
     */
    public function exportReport($examId)
    {
        $exam = Exam::with('hackathon', 'questions')->findOrFail($examId);
        $submissions = Submission::where('exam_id', $examId)->with('candidate')->orderBy('score', 'desc')->get();
        
        $totalSubmissions = $submissions->count();
        $averageScore = $submissions->avg('score') ?? 0;
        $averageCheatingScore = $submissions->avg('cheating_score') ?? 0;

        return view('organizer.report-export', compact(
            'exam',
            'submissions',
            'totalSubmissions',
            'averageScore',
            'averageCheatingScore'
        ));
    }

    /**
     * Delete Question from Exam
     */
    public function deleteQuestion($examId, $questionId)
    {
        $question = Question::where('exam_id', $examId)->findOrFail($questionId);
        $question->delete();

        return back()->with('success', 'Question deleted successfully!');
    }
}
