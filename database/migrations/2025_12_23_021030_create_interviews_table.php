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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('company')->index();
            $table->string('role')->index();

            $table->date('interview_date')->nullable()->index();
            $table->string('round_type',)->index();
            $table->json('questions_json')->nullable();
            $table->longText('answer_text')->nullable();
            $table->text('went_well')->nullable();
            $table->text('went_poorly')->nullable();
            $table->unsignedTinyInteger('self_confidence')->nullable(); // 0-10
            $table->string('outcome')->nullable(); // pass / fail/ next-round/offer



            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview');
    }
};
