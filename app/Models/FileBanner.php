<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileBanner extends Model
{
    use HasFactory;
    protected $table = 'file_banner';
    protected $primaryKey = 'id';

    protected $fillable = [
        'job_posting_id',
        'file_name',
    ];
}
