<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiOutput extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tips_json' => 'array',
        'practice_questions_json' => 'array',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }
}
