<?php

namespace Database\Factories;

use App\Models\Interview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interview>
 */
class InterviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
           'user_id' => \App\Models\User::factory(),
           'company' => fake()->company(),
           'role' => fake()->jobTitle(),
           'interview_date' => fake()->dateTimeBetween('-45 days', 'now')->format('Y-m-d'),
           'round_type' => fake()->randomElement(['HR','Technical','System Design','Hiring Manager']),
           'questions_json' => [fake()->sentence(), fake()->sentence()],
           'answer_text' => fake()->paragraphs(3, true),
           'went_well' => fake()->sentence(12),
           'went_poorly' => fake()->sentence(12),
           'self_confidence' => fake()->numberBetween(2, 10),
           'outcome' => fake()->randomElement(['Pending','Selected','Rejected']),
       ];
    }
}
