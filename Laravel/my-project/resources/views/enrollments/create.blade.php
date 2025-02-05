<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Enrollment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-4">
        <form action="{{ route('enrollments.store') }}" method="POST">
            @csrf

            <!-- Student -->
            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                <select name="student_id" id="student_id" class="mt-1 block w-full form-select @error('student_id') border-red-500 @enderror" required>
                    <option value="">Select a student</option>
                    @foreach ($students as $student)
                        @if (!in_array($student->id, $excludedStudentIds)) <!-- Exclude already enrolled students -->
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->fullname }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('student_id')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Semester -->
            <div class="mb-4">
                <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                <select name="semester_id" id="semester_id" class="mt-1 block w-full form-select @error('semester_id') border-red-500 @enderror" required>
                    <option value="">Select a semester</option>
                    @foreach ($semesters->filter(fn($semester) => $semester->is_active) as $semester)
                        <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                            {{ $semester->semester . ' Semester' }}
                        </option>
                    @endforeach
                </select>
                @error('semester_id')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course -->
            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                <select name="course_id" id="course_id" class="mt-1 block w-full form-select @error('course_id') border-red-500 @enderror" required>
                    <option value="">Select a course</option>
                    @foreach ($courses as $course)
                        @if (!in_array($course->id, $excludedCourseIds)) <!-- Exclude already selected courses -->
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Year Level -->
            <div class="mb-4">
                <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                <select name="year_level" id="year_level" class="mt-1 block w-full form-select @error('year_level') border-red-500 @enderror" required>
                    <option value="" disabled selected>Select Year Level</option>
                    @foreach (['1st_year', '2nd_year', '3rd_year', '4th_year', '5th_year', 'irregular'] as $yearLevel)
                        @if (!in_array($yearLevel, $excludedYearLevels)) <!-- Exclude excluded year levels -->
                            <option value="{{ $yearLevel }}" {{ old('year_level') == $yearLevel ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $yearLevel)) }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('year_level')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subjects (Checkboxes) -->
            <div class="mb-4">
                <label for="subjects" class="block text-sm font-medium text-gray-700">Subjects</label>
                <div class="space-y-2">
                    @foreach ($subjects as $subject)
                        @if (!in_array($subject->id, $excludedSubjectIds)) <!-- Exclude already enrolled subjects -->
                            <div class="flex items-center">
                                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}" 
                                       class="@error('subjects') border-red-500 @enderror"
                                       {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                                <label for="subject_{{ $subject->id }}" class="ml-2 text-sm text-gray-600">{{ $subject->name }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>
                @error('subjects')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('enrollments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    Back to Enrollments
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                    Save Enrollment
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
