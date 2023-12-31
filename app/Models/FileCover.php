<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileCover extends Model
{
    use HasFactory;
    protected $table = 'file_cover';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'file_name',
    ];
}
