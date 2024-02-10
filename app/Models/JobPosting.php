<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;

    protected $table = 'job_posting';
    protected $primaryKey = 'id';

    protected $fillable = [
        'adtype_id',
        'position_id',
        'paid',
        'date_posted',
        'is_hide_company_info',
        'is_hidden',
        'is_featured',
        'is_editable',
        'description',
        // new update
        'status',
    ];

    protected $casts = [
        'is_hide_company_info' => 'boolean',
        'is_hidden' => 'boolean',
        'is_featured' => 'boolean',
        'is_editable' => 'boolean',
        "paid" => 'boolean',
    ];

    function adtype()
    {
        return $this->hasOne(AdType::class, 'id', 'adtype_id');
    }

    function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }

    function banner()
    {
        return $this->hasOne(FileBanner::class, 'job_posting_id', 'id');
    }

    function sample_photos()
    {
        return $this->hasMany(FileSamplePhoto::class, 'job_posting_id', 'id');
    }

    function jobApplicants()
    {
        return $this->hasMany(JobApplicant::class);
    }
}
