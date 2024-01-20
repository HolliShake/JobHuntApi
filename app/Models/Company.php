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
    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'email',
        'description',
        'address',
        'user_id',
        'status',
        'verified_by_admin',
        'is_declined'
    ];

    protected $appends = [
        'average'
    ];

    protected $casts = [
        'average' => 'integer',
        'verified_by_admin' => 'boolean',
        'is_declined' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rating() {
        return $this->hasMany(Rating::class);
    }

    public function getAverageAttribute() {
        return (int) $this->rating->avg('rating');
    }
}
