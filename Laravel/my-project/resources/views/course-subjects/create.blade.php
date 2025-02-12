<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($courseSubject) ? 'Edit Course Subject' : 'Add Course Subject' }}
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <form action="{{ isset($courseSubject) ? route('course-subjects.update', $courseSubject->id) : route('course-subjects.store') }}" method="POST">
                @csrf
                @if(isset($courseSubject))
                    @method('PUT')
                @endif

                <!-- Subject Selection -->
                <div>
                    <label for="subject_id" class="block text-gray-700 dark:text-gray-200">Subject</label>
                    <select name="subject_id" id="subject_id" class="w-full border-gray-300 rounded mt-1">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" 
                                {{ isset($courseSubject) && $courseSubject->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Course Selection (Checkboxes) -->
                <div class="mt-4">
                    <label class="block text-gray-700 dark:text-gray-200">Assign to Courses</label>

                    @if($courses->isEmpty())
                        <p class="text-red-500">No available courses.</p>
                    @else
                        @foreach ($courses as $course)
                            <div class="flex items-center mt-2">
                                <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" 
                                    class="mr-2 text-blue-600"
                                    {{ in_array($course->id, $assignedCourses) ? 'checked' : '' }}>
                                <label class="text-gray-700 dark:text-gray-200">{{ $course->course_name }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="mt-6 flex justify-end gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        {{ isset($courseSubject) ? 'Update' : 'Save' }}
                    </button>
                    <a href="{{ route('course-subjects.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
