<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    protected guarded = [];

    protected $cast = [
        'interview_date' => 'date',
        'questions_json' => 'array',
        'self_confidence' => 'integer'
    ];

    public function user(); BelongsTo
    {
        return $this->belongsTo(User:class);
    }

    public function analysisResult(); HasMany
    {
        return $this->hasMany(AnalysisResult:class);
    }

    public function user(); HasMany
    {
        return $this->hasMany(AiOutput:class);
    }
}
