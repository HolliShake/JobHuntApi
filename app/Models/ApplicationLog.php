<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model
{
    use HasFactory;
    protected $table = 'application_logs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'event_date',
        'event_title',
        'event_description',
        'score',
        'job_applicant_id',
    ];
}
