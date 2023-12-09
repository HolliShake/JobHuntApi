<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    use HasFactory;
    protected $table = 'job_applicant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'job_posting_id',
        'user_id',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function job_posting() {
        return $this->belongsTo(JobPosting::class);
    }
}
