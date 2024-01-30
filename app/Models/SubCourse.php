<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCourse extends Model
{
    use HasFactory;

    protected $table = 'subcourses';
    protected $guarded = ["id"];  // handle of error
}
    