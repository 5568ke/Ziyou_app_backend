<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemRecord extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'paper_id', 'position', 'answer'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function paper()
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }
}
