<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hackathon extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'hackathons';

    protected $fillable = [
        'title',
        'description',
        'organizer_id',
        'start_date',
        'end_date',
        'banner_image',
        'status', // draft, active, completed
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'hackathon_id');
    }
}
