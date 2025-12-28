<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Interview Reflection</h2>
      <div class="space-x-3">
        <a href="{{ route('interviews.edit', $interview) }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Edit</a>
        <a href="{{ route('interviews.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Back</a>
      </div>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      @if (session('status'))
        <div class="mb-4 p-3 rounded bg-green-50 text-green-800">{{ session('status') }}</div>
      @endif

      <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500">Date:</span> {{ optional($interview->interview_date)->format('Y-m-d') }}</div>
            <div><span class="text-gray-500">Round:</span> {{ $interview->round_type ?? '—' }}</div>
            <div><span class="text-gray-500">Company:</span> {{ $interview->company ?? '—' }}</div>
            <div><span class="text-gray-500">Role:</span> {{ $interview->role ?? '—' }}</div>
            <div>
              <span class="text-gray-500">Confidence:</span>
              {{ $interview->self_confidence ? $interview->self_confidence.'/10' : '—' }}
            </div>
            <div><span class="text-gray-500">Outcome:</span> {{ $interview->outcome ?? '—' }}</div>
          </div>

          <hr />

          <div>
            <h3 class="font-semibold">Answers / Notes</h3>
            <p class="mt-1 whitespace-pre-wrap text-gray-800">{{ $interview->answers_text ?? '—' }}</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <h3 class="font-semibold">What went well</h3>
              <p class="mt-1 whitespace-pre-wrap text-gray-800">{{ $interview->went_well ?? '—' }}</p>
            </div>
            <div>
              <h3 class="font-semibold">What went poorly</h3>
              <p class="mt-1 whitespace-pre-wrap text-gray-800">{{ $interview->went_poorly ?? '—' }}</p>
            </div>
          </div>

          {{-- Later you can show analysis_results / ai_outputs here --}}
          <div class="mt-4 p-4 rounded bg-gray-50 text-gray-600 text-sm">
            ML analysis not run yet (Phase 4). This MVP is complete without it.
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
