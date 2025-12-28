<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 flex items-center justify-between">
          <div>
            <div class="text-gray-500 text-sm">Average confidence</div>
            <div class="text-2xl font-semibold">
              {{ $avgConfidence !== null ? $avgConfidence.'/10' : '—' }}
            </div>
          </div>
          <div class="text-gray-600">
            Total reflections: <span class="font-semibold">{{ $totalReflections }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
          <h3 class="font-semibold mb-4">Self-confidence trend</h3>

          @if(count($labels) === 0)
            <p class="text-gray-600">No confidence data yet. Create an interview reflection to see the trend.</p>
            <a href="{{ route('interviews.create') }}"
               class="inline-flex mt-3 items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
              + New Interview
            </a>
          @else
            <canvas id="confidenceChart" height="100"></canvas>
          @endif
        </div>
      </div>

    </div>
  </div>

  @if(count($labels) > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const labels = @json($labels);
      const values = @json($values);

      const ctx = document.getElementById('confidenceChart');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [{
            label: 'Self-confidence (1-10)',
            data: values,
            tension: 0.3
          }]
        },
        options: {
          scales: {
            y: { min: 0, max: 10, ticks: { stepSize: 1 } }
          }
        }
      });
    </script>
  @endif
</x-app-layout>
