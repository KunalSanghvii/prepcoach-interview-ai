<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Interviews</h2>
      <a href="{{ route('interviews.create') }}"
         class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
        + New Interview
      </a>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if (session('status'))
        <div class="mb-4 p-3 rounded bg-green-50 text-green-800">{{ session('status') }}</div>
      @endif

      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        <div class="p-6">
          @if($interviews->count() === 0)
            <p class="text-gray-600">No interviews yet. Create your first reflection.</p>
          @else
            <div class="overflow-x-auto">
              <table class="min-w-full text-sm">
                <thead>
                  <tr class="text-left text-gray-600 border-b">
                    <th class="py-2">Date</th>
                    <th class="py-2">Company</th>
                    <th class="py-2">Role</th>
                    <th class="py-2">Round</th>
                    <th class="py-2">Confidence</th>
                    <th class="py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($interviews as $i)
                    <tr class="border-b">
                      <td class="py-2">{{ optional($i->interview_date)->format('Y-m-d') }}</td>
                      <td class="py-2">{{ $i->company ?? '—' }}</td>
                      <td class="py-2">{{ $i->role ?? '—' }}</td>
                      <td class="py-2">{{ $i->round_type ?? '—' }}</td>
                      <td class="py-2">
                        @if($i->self_confidence)
                          <span class="px-2 py-1 rounded bg-indigo-50 text-indigo-700">{{ $i->self_confidence }}/10</span>
                        @else
                          <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">—</span>
                        @endif
                      </td>
                      <td class="py-2 space-x-3">
                        <a class="text-indigo-700 hover:underline" href="{{ route('interviews.show', $i) }}">View</a>
                        <a class="text-gray-700 hover:underline" href="{{ route('interviews.edit', $i) }}">Edit</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="mt-4">
              {{ $interviews->links() }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
