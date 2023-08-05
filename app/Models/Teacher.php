<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Teacher extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
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


    public function School(): BelongsTo {
        return $this->belongsTo(School::class,'School_id');
    }

    public function Classes(): HasMany{
        return $this->hasMany(Classe::class);
    }

}
