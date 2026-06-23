<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hackathon;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Submission;
use App\Models\Analytic;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Clear Existing Collections in MongoDB
        User::truncate();
        Hackathon::truncate();
        Exam::truncate();
        Question::truncate();
        Submission::truncate();
        Analytic::truncate();
        Notification::truncate();

        // 2. Create Users
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@proctored.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'profile_picture' => 'https://api.dicebear.com/7.x/bottts/svg?seed=admin',
        ]);

        $organizer = User::create([
            'name' => 'Dr. Sophia Carter',
            'email' => 'organizer@proctored.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'profile_picture' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Sophia',
        ]);

        $candidate = User::create([
            'name' => 'Alex Rivera',
            'email' => 'candidate@proctored.com',
            'password' => Hash::make('password'),
            'role' => 'candidate',
            'profile_picture' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Alex',
        ]);

        $proctor = User::create([
            'name' => 'Proctor Agent Alpha',
            'email' => 'proctor@proctored.com',
            'password' => Hash::make('password'),
            'role' => 'proctor',
            'profile_picture' => 'https://api.dicebear.com/7.x/bottts/svg?seed=proctor',
        ]);

        // 3. Create Hackathon
        $hackathon = Hackathon::create([
            'title' => 'Global HackAI 2026',
            'description' => 'The premier international hackathon designed to push the boundaries of Agentic AI, large language model fine-tuning, and robust full-stack applications. Shortlisted candidates will compete in virtual sandboxes for a $50,000 grand prize.',
            'organizer_id' => $organizer->id,
            'start_date' => Carbon::now()->addDays(2),
            'end_date' => Carbon::now()->addDays(5),
            'banner_image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
            'status' => 'active',
        ]);

        // 4. Create Exam
        $exam = Exam::create([
            'hackathon_id' => $hackathon->id,
            'title' => 'AI Screening & Algorithmic Round',
            'description' => 'This screening round contains general aptitude, artificial intelligence multiple choice questions, and a coding challenge. Your browser environment, window changes, and webcam feed are monitored in real-time by AI proctoring services.',
            'duration_minutes' => 60,
            'rules' => [
                'Do not switch browser tabs or exit fullscreen mode. Doing so creates visual alert logs.',
                'The webcam stream is checked periodically. Only one face should be visible at all times.',
                'Right-click and text copy-pasting is strictly disabled.',
                'Answers are autosaved progressively. If you drop internet connection, the system attempts to resync.',
            ],
            'anti_cheating' => [
                'webcam_required' => true,
                'block_tab_switch' => true,
                'enforce_fullscreen' => true,
                'block_copy_paste' => true,
            ],
        ]);

        // 5. Create Questions
        // Q1: MCQ Aptitude
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'mcq',
            'question_text' => 'A train running at the speed of 60 km/hr crosses a pole in 9 seconds. What is the length of the train in meters?',
            'options' => [
                '120 meters',
                '150 meters',
                '324 meters',
                '180 meters'
            ],
            'correct_answer' => '1', // Index of "150 meters"
            'points' => 10,
            'difficulty' => 'easy',
        ]);

        // Q2: MCQ AI/ML
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'mcq',
            'question_text' => 'Which mathematical activation function is commonly utilized in artificial neural network output layers to produce probability distributions for binary classification tasks?',
            'options' => [
                'Softmax Function',
                'Rectified Linear Unit (ReLU)',
                'Sigmoid Function',
                'Hyperbolic Tangent (Tanh)'
            ],
            'correct_answer' => '2', // Index of "Sigmoid Function"
            'points' => 10,
            'difficulty' => 'easy',
        ]);

        // Q3: Coding Question (LeetCode TwoSum)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'coding',
            'question_text' => 'Write a function "twoSum" that takes an array of integers "nums" and an integer "target", and returns the 0-indexed indices of the two numbers such that they add up to "target". You may assume that each input would have exactly one solution, and you may not use the same element twice.',
            'coding_template' => [
                'python' => "def twoSum(nums, target):\n    # Write your Python 3 code here\n    # Example return: [0, 1]\n    pass",
                'javascript' => "function twoSum(nums, target) {\n    // Write your Javascript code here\n    // Example return: [0, 1]\n    return [];\n}",
                'php' => "function twoSum(\$nums, \$target) {\n    // Write your PHP code here\n    // Example return: [0, 1]\n    return [];\n}"
            ],
            'test_cases' => [
                [
                    'input' => '[2, 7, 11, 15], 9',
                    'output' => '[0, 1]',
                    'is_hidden' => false
                ],
                [
                    'input' => '[3, 2, 4], 6',
                    'output' => '[1, 2]',
                    'is_hidden' => false
                ],
                [
                    'input' => '[3, 3], 6',
                    'output' => '[0, 1]',
                    'is_hidden' => true
                ]
            ],
            'points' => 30,
            'difficulty' => 'medium',
        ]);

        // Q4: MCQ Aptitude (Work pace)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'mcq',
            'question_text' => 'If 5 developers can grade 10 hackathon submissions in 2 hours, how many hours will it take 3 developers to grade 30 submissions, assuming they operate at the same constant speed?',
            'options' => [
                '10 hours',
                '6 hours',
                '8 hours',
                '12 hours'
            ],
            'correct_answer' => '0', // Index of "10 hours"
            'points' => 10,
            'difficulty' => 'medium',
        ]);

        // Q5: MCQ Aptitude (Simple Probability)
        Question::create([
            'exam_id' => $exam->id,
            'type' => 'aptitude',
            'question_text' => 'A bag contains 6 red marbles, 4 blue marbles, and 5 green marbles. If a candidate pulls 1 marble out at random, what is the probability that it is green?',
            'options' => [
                '1/3',
                '2/5',
                '1/5',
                '4/15'
            ],
            'correct_answer' => '0', // Index of "1/3" (5/15 = 1/3)
            'points' => 10,
            'difficulty' => 'easy',
        ]);

        // 6. Create notifications
        Notification::create([
            'user_id' => $candidate->id,
            'title' => 'Registered for Global HackAI 2026',
            'message' => 'Congratulations! Your profile has been accepted for Global HackAI 2026. You can now access your screening exam.',
            'is_read' => false,
            'type' => 'exam_start',
        ]);

        // 7. Seed an analytics report for default exams
        Analytic::create([
            'exam_id' => $exam->id,
            'average_score' => 42.5,
            'completion_rate' => 88.0,
            'cheating_rate' => 4.2,
            'difficulty_distribution' => [
                'easy' => 85,
                'medium' => 62,
                'hard' => 31
            ],
            'performance_trends' => [
                'scores' => [30, 45, 55, 60, 40, 75, 80, 20, 50, 45],
                'dates' => ['May 18', 'May 19', 'May 20', 'May 21', 'May 22', 'May 23', 'May 24', 'May 25', 'May 26', 'May 27']
            ]
        ]);
    }
}
