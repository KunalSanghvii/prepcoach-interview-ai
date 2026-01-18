<?php

namespace App\Jobs;

use App\Models\Interview;
use App\Models\AnalysisResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Throwable;

class AnalyzeInterviewReflectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $interviewId,
        public string $modelVersion = 'ml-v1'
    ) {}

    public int $tries = 5;

    public function backoff(): array
    {
        return [10, 30, 60, 120, 300];
    }

    public function handle(): void
    {
        $interview = Interview::findOrFail($this->interviewId);

        // mark pending/started
        $interview->analysis_status = 'pending';
        $interview->analysis_started_at ??= now();
        $interview->analysis_attempts = (int) $interview->analysis_attempts + 1;
        $interview->analysis_error = null;
        $interview->save();

        $payload = [
            'interview_id'    => $interview->id,
            'model_version'   => $this->modelVersion,
            'reflection_text' => (string) ($interview->reflection_text ?? ''),
            'answers'         => $interview->answers_json ?? null,
        ];

        $baseUrl = rtrim(config('services.ml.base_url'), '/');
        $url = $baseUrl . '/v1/analyze';

        $response = Http::timeout(8)
            ->retry(0, 0) // queue handles retries
            ->acceptJson()
            ->post($url, $payload);

        if (!$response->successful()) {
            throw new \RuntimeException("ML analyze failed: HTTP {$response->status()} - " . $response->body());
        }

        $analysis = $response->json();

        if (!is_array($analysis)) {
            throw new \RuntimeException("ML analyze returned non-JSON response.");
        }

        AnalysisResult::updateOrCreate(
            [
                'interview_id'  => $interview->id,
                'model_version' => $this->modelVersion,
            ],
            [
                'sentiment_label' => $analysis['sentiment_label'] ?? $analysis['sentiment'] ?? null,
                'sentiment_score' => $analysis['sentiment_score'] ?? null,
                'clarity_score'   => isset($analysis['clarity_score']) ? (int) $analysis['clarity_score'] : null,
                'star_score'      => isset($analysis['star_score']) ? (int) $analysis['star_score'] : null,
                'topics_json'     => $analysis['topics'] ?? $analysis['topics_json'] ?? null,
                'signals_json'    => $analysis['signals'] ?? $analysis['signals_json'] ?? null,
            ]
        );

        $interview->analysis_status = 'success';
        $interview->analysis_completed_at = now();
        $interview->analysis_error = null;
        $interview->save();
    }

    public function failed(Throwable $e): void
    {
        $interview = Interview::find($this->interviewId);
        if (!$interview) return;

        $interview->analysis_status = 'failed';
        $interview->analysis_completed_at = now();
        $interview->analysis_error = mb_strcut($e->getMessage(), 0, 2000);
        $interview->save();
    }
}
