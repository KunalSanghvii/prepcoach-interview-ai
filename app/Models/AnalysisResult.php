<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisResult extends Model
{
    protected $guarded = [];

    protected $casts = [
        'sentiment_score' => 'float',
        'confidence_est' => 'float',
        'topics_json' => 'array',
        'signals_json' => 'array',
        'clarity_score' => 'integer',
        'star_score' => 'integer',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }
}
