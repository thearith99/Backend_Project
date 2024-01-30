<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'title', 'grade_id']; // Add 'grade_id' to fillable

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
