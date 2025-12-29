<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interview extends Model
{

    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'interview_date' => 'date',
        'questions_json' => 'array',
        'self_confidence' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function analysisResult(): hasMany
    {
        return $this->hasMany(AnalysisResult::class);
    }

    public function aiOutputs(): hasMany
    {
        return $this->hasMany(AiOutput::class);
    }
}
