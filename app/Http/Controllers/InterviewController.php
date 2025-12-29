<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Interview;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InterviewController extends Controller
{
    use AuthorizesRequests;

    public function index() {
        $interviews = Interview::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('interview_date')
            ->orderByDesc('id')
            ->paginate(10);

        return view('interviews.index', compact('interviews'));
    }

    public function create() {
        return view('interviews.create');
    }

    public function store(Request $request) {
        $validated = $this->validatedInterview($request);

        $validated['user_id'] = auth()->id();

        if (array_key_exists('questions_json', $validated) && $validated['questions_json'] === null) {
            $validated['questions_json'] = null;
        }

        $interview = Interview::create($validated);

        return redirect()
            ->route('interviews.show', $interview)
            ->with('status', 'Interview saved.');


    }

    public function show(Interview $interview) {
        $this->authorize('view', $interview);
        return view('interviews.show', compact('interview'));

    }

    public function edit(Interview $interview) {
        $this->authorize('update', $interview);
        return view('interviews.edit', compact('interview'));

    }

    public function update(Request $request, Interview $interview)
    {
        $this->authorize('update', $interview);

        $validated = $this->validatedInterview($request);

        unset($validated['user_id']);

        $interview->update($validated);

        return redirect()
            ->route('interviews.show', $interview)
            ->with('status', 'Interview updated.');
    }

 private function validatedInterview(Request $request): array
    {
        return $request->validate([
            'company' => ['nullable', 'string', 'max:120'],
            'role' => ['nullable', 'string', 'max:120'],
            'interview_date' => ['required', 'date'],
            'round_type' => ['nullable', 'string', 'max:60'],
            'questions_json' => ['nullable'], // we’ll normalize in model/form later
            'answer_text' => ['nullable', 'string'],
            'went_well' => ['nullable', 'string'],
            'went_poorly' => ['nullable', 'string'],
            'self_confidence' => ['nullable', 'integer', 'min:1', 'max:10'],
            'outcome' => ['nullable', 'string', 'max:60'],
        ]);
    }
}
