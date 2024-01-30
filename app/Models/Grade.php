<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';
    protected $guarded = ["id"];  // handle of error

    public function getAllGrade(){
        // one to many
        return $this->hasMany(Course::class);
    }
}
