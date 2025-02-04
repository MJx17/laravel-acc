<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Enrollment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-4">
        <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Student -->
            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                <select name="student_id" id="student_id" class="mt-1 block w-full form-select" required>
                    <option value="">Select a student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ $student->id == $enrollment->student_id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Semester -->
            <div class="mb-4">
                <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                <select name="semester_id" id="semester_id" class="mt-1 block w-full form-select" required>
                    <option value="">Select a semester</option>
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ $semester->id == $enrollment->semester_id ? 'selected' : '' }}>
                            {{ $semester->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Course -->
            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                <select name="course_id" id="course_id" class="mt-1 block w-full form-select" required>
                    <option value="">Select a course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ $course->id == $enrollment->course_id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Year Level -->
            <div class="mb-4">
                <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                <input type="number" name="year_level" id="year_level" class="mt-1 block w-full form-input" value="{{ old('year_level', $enrollment->year_level) }}" required>
            </div>

            <!-- Subjects (Checkboxes) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Subjects</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($subjects as $subject)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" 
                                {{ in_array($subject->id, $enrollment->subjects->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <span>{{ $subject->subject_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('enrollments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    Back to Enrollments
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                    Update Enrollment
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
