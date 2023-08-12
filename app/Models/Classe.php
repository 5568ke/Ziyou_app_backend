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
    public function Papers(){
        return $this->hasMany(Paper::class,'Class_id');
    }

    public function generateInviteCode()
    {
        $code = uniqid();

        while (self::where('invite_code', $code)->exists()) {
            $code = uniqid();
        }

        $this->invite_code = $code;
        $this->save();

        return $code;
    }
}
