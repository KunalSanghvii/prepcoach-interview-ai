<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->string('analysis_status')->default('pending'); // pending|success|failed
            $table->string('ai_status')->default('pending');       // pending|success|failed

            $table->unsignedSmallInteger('analysis_attempts')->default(0);
            $table->text('analysis_error')->nullable();

            $table->timestamp('analysis_started_at')->nullable();
            $table->timestamp('analysis_completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn([
                'analysis_status',
                'ai_status',
                'analysis_attempts',
                'analysis_error',
                'analysis_started_at',
                'analysis_completed_at',
            ]);
        });
    }
};
