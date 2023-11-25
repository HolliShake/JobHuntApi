<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $table = 'office';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'country',
        'address',
        'mobile_number',
        'company_id'
    ];
}
