<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubEducation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sub_education';

    protected $fillable = [
        'name',
        'education_id',
        'created_by'
    ];
}
