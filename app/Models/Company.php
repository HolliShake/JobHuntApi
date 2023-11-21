<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'company';
    protected $primaryKey = 'id';
    protected $timestamps = false;

    protected $fillable = [
        'company_name',
        'email',
        'description',
        'address',
        'user_id'
    ];
}