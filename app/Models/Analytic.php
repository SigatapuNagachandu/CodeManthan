<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Analytic extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'analytics';

    protected $fillable = [
        'exam_id',
        'average_score',
        'completion_rate',
        'cheating_rate',
        'difficulty_distribution', // array: ['easy' => 80, 'medium' => 60...]
        'performance_trends', // array/object mapping
    ];

    protected $casts = [
        'average_score' => 'float',
        'completion_rate' => 'float',
        'cheating_rate' => 'float',
        'difficulty_distribution' => 'array',
        'performance_trends' => 'array',
    ];

    /**
     * Relationships
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
