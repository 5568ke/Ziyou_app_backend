<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'Class_id',
        'status',
        'deadline',
    ];

    public function Class(): BelongsTo {
        return $this->belongsTo(Classe::class,'Class_id');
    }

    public function problems(){
        return $this->belongsToMany(Problem::class);
    }
}
