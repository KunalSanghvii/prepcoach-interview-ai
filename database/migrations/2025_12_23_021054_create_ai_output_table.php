<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_output', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->cascadeOnDelete();

            $table->longText('star_rewrite')->nullable();
            $table->json('tips_json')->nullable();
            $table->json('practice_questions_json')->nullable();

            $table->string('llm_provider', 30)->default('none')->index(); // ollama/openai/none
            $table->string('prompt_version', 50)->index(); // prompt-v1, prompt-v2

            $table->timestamps();

            // Optional but recommended: one output per interview per provider+prompt_version
            $table->unique(['interview_id', 'llm_provider', 'prompt_version'], 'uniq_ai_interview_provider_prompt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_output');
    }
};
