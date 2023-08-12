<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_id',
        'student_id',
        'status',
        'score',
        'makeTime',
    ];

    // Define relationships
    public function paper()
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
