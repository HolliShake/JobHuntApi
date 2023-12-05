<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    use HasFactory;
    protected $table = 'personal_data';

    protected $fillable = [
        'address',
        'postal',
        'municipality',
        'city',
        'religion',
        'civil_status',
        'citizenship',
        // Mother
        'mother_first_name',
        'mother_middle_name',
        'mother_last_name',
        // Father
        'father_first_name',
        'father_middle_name',
        'father_last_name',
        // Fk
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function skill() {
        return $this->hasMany(Skill::class, 'personal_data_id', 'id');
    }

    public function education() {
        return $this->hasMany(Education::class, 'personal_data_id', 'id');
    }
}
