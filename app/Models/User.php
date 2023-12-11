<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'suffix',
        'gender',
        'birth_date',
        'mobile_number',
        'address',
        'country',
    ];

    protected $appends = [
        'JobExperience'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // user access
    public function user_access()
    {
        return $this->hasMany(UserAccess::class, 'user_id', 'id');
    }

    //
    public function personal_data()
    {
        return $this->hasOne(PersonalData::class, 'user_id', 'id');
    }

    public function profile_image()
    {
        return $this->hasOne(FileProfile::class, 'user_id', 'id');
    }

    public function cover_image()
    {
        return $this->hasOne(FileCover::class, 'user_id', 'id');
    }

    public function getJobExperienceAttribute() {
        return $this->hasMany(JobApplicant::class)->with([
            'job_posting' => function($query) {
                $query->with([
                    'position' => function($query) {
                        $query->with('company')->with('office');
                    }
                ]);
            }
        ])->where('status', 'accepted')->whereIn('id', HiredApplicant::select('job_applicant_id')->get())->get();
    }
}
