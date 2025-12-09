<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Util\PHP\Job;

class UserDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'gender',
        'current_location_country_id',
        'dob',
        'age',
        'passport_no',
        'job_id',
        'education_id',
        'sub_education_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'current_location_country_id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    public function subeducation()
    {
        return $this->belongsTo(SubEducation::class, 'sub_education_id');
    }

    public function job()
    {
        return $this->belongsTo(Jobs::class, 'job_id');
    }
}
