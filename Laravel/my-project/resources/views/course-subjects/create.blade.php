<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Course Subject') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <form action="{{ route('course-subjects.store') }}" method="POST">
                @csrf

                <div>
                    <label for="course_id" class="block text-gray-700 dark:text-gray-200">Course</label>
                    <select name="course_id" id="course_id" class="w-full border-gray-300 rounded mt-1">
                @foreach ($courses as $course)  <!-- Corrected variable name -->
                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
                    </select>

                </div>

                <div class="mt-4">
                    <label for="subject_id" class="block text-gray-700 dark:text-gray-200">Subject</label>
                    <select name="subject_id" id="subject_id" class="w-full border-gray-300 rounded mt-1">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    <a href="{{ route('course-subjects.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
