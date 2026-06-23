<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProctorLog extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'proctor_logs';

    protected $fillable = [
        'submission_id',
        'candidate_id',
        'snapshots', // array of objects: [['timestamp' => '...', 'image' => 'base64_data_or_path']]
        'event_summary', // general notes
    ];

    protected $casts = [
        'snapshots' => 'array',
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
