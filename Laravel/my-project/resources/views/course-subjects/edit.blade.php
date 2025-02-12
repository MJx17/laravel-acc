<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Course: {{ $course->course_name }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <form action="{{ route('courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Hidden input to store course ID -->
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <!-- Subject Selection (Checkboxes) -->
                <div class="mt-4">
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold">Assign Subjects to Course</label>

                    @if($subjects->isEmpty())
                        <p class="text-red-500 mt-2">No available subjects.</p>
                    @else
                        @foreach ($subjects as $subject)
                            <div class="flex items-center mt-2">
                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" 
                                    class="mr-2 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-400"
                                    {{ in_array($subject->id, $assignedSubjects) ? 'checked' : '' }}>
                                <label class="text-gray-700 dark:text-gray-200">{{ $subject->name }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="mt-6 flex justify-end gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        Update
                    </button>
                    <a href="{{ route('courses.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
