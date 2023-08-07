<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'grade',
        'Classe_id',
        'School_id',
        // Add other fields if necessary
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function Classe(): BelongsTo {
        return $this->belongsTo(Classe::class,'Classe_id');
    }

    public function School(): BelongsTo {
        return $this->belongsTo(School::class,'School_id');
    }
}
