<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'applicantId',
        'name',
        'description',
    ];
}
