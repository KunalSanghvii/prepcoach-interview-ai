<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Interview Reflection</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
          <form method="POST" action="{{ route('interviews.store') }}">
            @csrf
            @include('interviews._form')
            <div class="mt-6 flex gap-3">
              <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save</button>
              <a href="{{ route('interviews.index') }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
