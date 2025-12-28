@php
  $isEdit = isset($interview);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <x-input-label for="interview_date" value="Interview Date *" />
    <x-text-input id="interview_date" name="interview_date" type="date" class="mt-1 block w-full"
      value="{{ old('interview_date', $isEdit ? optional($interview->interview_date)->format('Y-m-d') : '') }}" required />
    <x-input-error class="mt-2" :messages="$errors->get('interview_date')" />
  </div>

  <div>
    <x-input-label for="round_type" value="Round Type" />
    <x-text-input id="round_type" name="round_type" type="text" class="mt-1 block w-full"
      value="{{ old('round_type', $isEdit ? $interview->round_type : '') }}" placeholder="HR / Technical / Hiring Manager" />
    <x-input-error class="mt-2" :messages="$errors->get('round_type')" />
  </div>

  <div>
    <x-input-label for="company" value="Company" />
    <x-text-input id="company" name="company" type="text" class="mt-1 block w-full"
      value="{{ old('company', $isEdit ? $interview->company : '') }}" />
    <x-input-error class="mt-2" :messages="$errors->get('company')" />
  </div>

  <div>
    <x-input-label for="role" value="Role" />
    <x-text-input id="role" name="role" type="text" class="mt-1 block w-full"
      value="{{ old('role', $isEdit ? $interview->role : '') }}" />
    <x-input-error class="mt-2" :messages="$errors->get('role')" />
  </div>
</div>

<div class="mt-4">
  <x-input-label for="self_confidence" value="Self-Confidence (1–10)" />
  <x-text-input id="self_confidence" name="self_confidence" type="number" min="1" max="10" class="mt-1 block w-full"
    value="{{ old('self_confidence', $isEdit ? $interview->self_confidence : '') }}" />
  <x-input-error class="mt-2" :messages="$errors->get('self_confidence')" />
</div>

<div class="mt-4">
  <x-input-label for="answers_text" value="Answers / Notes (what you said)" />
  <textarea id="answers_text" name="answers_text" rows="6"
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('answers_text', $isEdit ? $interview->answers_text : '') }}</textarea>
  <x-input-error class="mt-2" :messages="$errors->get('answers_text')" />
</div>

<div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <x-input-label for="went_well" value="What went well" />
    <textarea id="went_well" name="went_well" rows="5"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('went_well', $isEdit ? $interview->went_well : '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('went_well')" />
  </div>

  <div>
    <x-input-label for="went_poorly" value="What went poorly" />
    <textarea id="went_poorly" name="went_poorly" rows="5"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('went_poorly', $isEdit ? $interview->went_poorly : '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('went_poorly')" />
  </div>
</div>

<div class="mt-4">
  <x-input-label for="outcome" value="Outcome (optional)" />
  <x-text-input id="outcome" name="outcome" type="text" class="mt-1 block w-full"
    value="{{ old('outcome', $isEdit ? $interview->outcome : '') }}" placeholder="Pending / Selected / Rejected" />
  <x-input-error class="mt-2" :messages="$errors->get('outcome')" />
</div>
