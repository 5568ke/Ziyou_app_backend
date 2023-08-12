<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paper;

class Problem extends Model
{
    use HasFactory;

    protected $fillable=[
        'problemNum',
        'problemLink',
        'ansLink',
        'answer',
        'choices',
        'position',
    ];


    public function Papers(){
        return $this->belongsToMany(Paper::class);
    }
}
