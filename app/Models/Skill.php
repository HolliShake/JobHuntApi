<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'personal_data_id',
        'title',
        'description',
        'progress',
    ];

    public function personal_data() {
        return $this->hasOne(PersonalData::class, 'id', 'personal_data_id');
    }
}
