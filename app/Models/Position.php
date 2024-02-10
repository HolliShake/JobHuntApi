<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;
    public $table = 'position';
    protected $fillable = [
        'title',
        'slots',
        'description',
        'employment_type',
        'payment_type',
        'skills',
        'salary_id',
        'office_id',
        'company_id'
    ];

    public function salary() {
        return $this->hasOne(Salary::class, 'id', 'salary_id');
    }

    public function office() {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function jobPosting() {
        return $this->hasMany(JobPosting::class);
    }
}
