<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileProfile extends Model
{
    use HasFactory;
    protected $table = 'file_profile';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'file_name',
    ];
}
