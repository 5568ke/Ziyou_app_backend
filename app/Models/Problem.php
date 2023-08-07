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
        'problem_name',
        'problem_link',
        'answer_link',
        'answer',
        'choices',
    ]

    public function Papers(): BelongsTo {
        return $this->belongsTomany(Paper::class);
    }


}
