<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'rating';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'company_id',
        'rating',
        'comment',
    ];

    function user() {
        return $this->belongsTo(User::class);
    }
}
