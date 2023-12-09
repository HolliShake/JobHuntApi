<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiredApplicant extends Model
{
    use HasFactory;
    protected $table = 'hired_applicant';
    protected $primaryKey = 'id';

    protected $fillable = [
        'job_applicant_id',
    ];

    function job_applicant() {
        return $this->belongsTo(JobApplicant::class);
    }
}
