<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
        'class_name',
        'version',
        'invite_code',
        'Teacher_id'
    ];

    public function Teacher(): BelongsTo {
        return $this->belongsTo(Teacher::class,'Teacher_id');
    }
}
