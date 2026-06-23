<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'questions';

    protected $fillable = [
        'exam_id',
        'type', // mcq, coding, aptitude
        'question_text',
        'options', // array of strings (for MCQ/aptitude)
        'correct_answer', // string (index/value) or array
        'coding_template', // array of key-value: 'python' => 'def solve()...', 'javascript' => 'function solve()...'
        'test_cases', // array of objects: [['input' => '1 2', 'output' => '3', 'is_hidden' => false]]
        'points',
        'difficulty', // easy, medium, hard
    ];

    protected $casts = [
        'options' => 'array',
        'coding_template' => 'array',
        'test_cases' => 'array',
        'points' => 'integer',
    ];

    /**
     * Relationships
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
