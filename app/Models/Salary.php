<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = 'salary';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'level',
        'value',
        'company_id'
    ];
}
