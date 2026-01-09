<?php

namespace App\Jobs;

use App\Models\Interview;
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

    // "N retries"
    public int $tries = 5;

    // backoff (seconds): 10s, 30s, 60s, 2m, 5m
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

        // Build payload - adapt fields to your schema
        $payload = [
            'interview_id'    => $interview->id,
            'model_version'   => $this->modelVersion,
            'reflection_text' => (string) ($interview->reflection_text ?? ''),
            'answers'         => $interview->answers_json ?? null, // optional
        ];

        $baseUrl = rtrim(config('services.ml.base_url'), '/'); // e.g. http://ml:8000
        $url = $baseUrl . '/v1/analyze';

        $response = Http::timeout(8)
            ->retry(0, 0) // IMPORTANT: don't double-retry here; queue already retries
            ->acceptJson()
            ->post($url, $payload);

        if (!$response->successful()) {
            // Throw => queue will retry based on tries/backoff
            throw new \RuntimeException("ML analyze failed: HTTP {$response->status()} - ".$response->body());
        }

        $analysis = $response->json();

        // Save results
        $interview->analysis_json = $analysis;         // if you added this column
        $interview->analysis_status = 'success';
        $interview->analysis_completed_at = now();
        $interview->analysis_error = null;
        $interview->save();
    }

    public function failed(Throwable $e): void
    {
        // This runs after all retries exhausted
        $interview = Interview::find($this->interviewId);
        if (!$interview) return;

        $interview->analysis_status = 'failed';
        $interview->analysis_completed_at = now();
        $interview->analysis_error = mb_strcut($e->getMessage(), 0, 2000);
        $interview->save();
    }
}
