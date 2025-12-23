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
        Schema::create('analysis_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->cascadeOnDelete();
            $table->string('sentiment_label', 30)->nullable(); //positive, neutral, negative
            $table->decimal('sentiment_score', 5, 4)->nullable(); //-1, 0 , 1
            $table->unsignedTinyInteger('clarity_score')->nullable(); // 0-5 or 0-10
            $table->unsignedTinyInteger('star_score')->nullable();   // 1-5
            $table->json('topics_json')->nullable();
            $table->json('signals_json')->nullable();

            $table->string('model_version', 50)->index(); // ml-v1, ml-v2
            $table->timestamps();

            $table->unique(['interview_id', 'model_version'], 'uniq_analysis_interview_model');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analysis_result');
    }
};
