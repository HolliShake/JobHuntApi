<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'personal_data_id',
        'school_name',
        'location',
        'status',
        'description',
        'start_sy',
        'end_sy',
    ];

    public function personal_data() {
        return $this->hasOne(PersonalData::class, 'id', 'personal_data_id');
    }
}
