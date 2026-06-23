<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'exams';

    protected $fillable = [
        'hackathon_id',
        'title',
        'description',
        'duration_minutes',
        'rules', // array of rule strings
        'anti_cheating', // array/object: webcam_required, block_tab_switch, enforce_fullscreen, block_copy_paste
    ];

    protected $casts = [
        'rules' => 'array',
        'anti_cheating' => 'array',
    ];

    /**
     * Relationships
     */
    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class, 'hackathon_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'exam_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'exam_id');
    }

    public function analytics()
    {
        return $this->hasOne(Analytic::class, 'exam_id');
    }
}
