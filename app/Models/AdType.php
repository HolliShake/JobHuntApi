<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdType extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $table = 'adtype';

    protected $fillable = [
        'type',
        'price',
        'duration',
        'max_skills_matching',
        'is_search_priority',
        'is_featured',
        'is_analytics_available',
        'is_editable'
    ];

    protected $casts = [
        'is_search_priority' => 'boolean',
        'is_featured' => 'boolean',
        'is_analytics_available' => 'boolean',
        'is_editable' => 'boolean'
    ];
}


