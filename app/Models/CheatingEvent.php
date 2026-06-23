<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheatingEvent extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'cheating_events';

    protected $fillable = [
        'submission_id',
        'candidate_id',
        'event_type', // tab_switch, exit_fullscreen, multiple_faces, no_face, right_click_attempt, copy_paste_attempt, offline
        'timestamp', // datetime
        'screenshot_url', // or base64 image
        'severity', // low, medium, high
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }
}
