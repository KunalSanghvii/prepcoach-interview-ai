<?php

namespace App\Jobs;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GenerateInterviewAiAnalysisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $interviewId) {}

    public function handle(): void
    {
        $interview = Interview::findOrFail($this->interviewId);

        $interview->update([
            'ai_analysis_status' => 'processing',
        ]);

        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->timeout(120)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an interview coach. Return structured JSON only.'
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode([
                            'company' => $interview->company,
                            'role' => $interview->role,
                            'round' => $interview->round,
                            'notes' => $interview->notes,
                            'went_well' => $interview->went_well,
                            'went_poorly' => $interview->went_poorly,
                        ])
                    ]
                ],
                'temperature' => 0.4,
            ]);

        if (!$response->successful()) {
            $interview->update([
                'ai_analysis_status' => 'failed',
                'ai_analysis_error' => $response->body(),
            ]);
            return;
        }

        $content = $response->json('choices.0.message.content');
        $analysis = json_decode($content, true);

        if (!is_array($analysis)) {
            $interview->update([
                'ai_analysis_status' => 'failed',
                'ai_analysis_error' => 'Invalid JSON from GPT',
            ]);
            return;
        }

        $interview->update([
            'ai_analysis_status' => 'completed',
            'ai_analysis_model' => env('OPENAI_MODEL'),
            'ai_analysis_generated_at' => now(),
            'ai_analysis_json' => $analysis,
        ]);
    }
}
