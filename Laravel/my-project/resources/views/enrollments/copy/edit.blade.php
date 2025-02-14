<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Enrollment') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-12 px-6 sm:px-8 lg:px-10">
        <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Edit Enrollment</h2>

            <form method="POST" action="{{ route('enrollments.update', $enrollment->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Student Selection (Disabled) -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Student</label>
                    <select name="student_id" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" disabled>
                        <option value="{{ $enrollment->student->id }}" selected>{{ $enrollment->student->fullname }}</option>
                    </select>
                </div>

                <!-- Course Selection -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Course</label>
                    <select name="course_id" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $course->id == $enrollment->course_id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester Selection -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Semester</label>
                    <select name="semester_id" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ $semester->id == $enrollment->semester_id ? 'selected' : '' }}>
                                {{ $semester->semester }} Semester
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Level Selection -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Year Level</label>
                    <select name="year_level" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="first_year" {{ $enrollment->year_level == 'first_year' ? 'selected' : '' }}>First Year</option>
                        <option value="second_year" {{ $enrollment->year_level == 'second_year' ? 'selected' : '' }}>Second Year</option>
                        <option value="third_year" {{ $enrollment->year_level == 'third_year' ? 'selected' : '' }}>Third Year</option>
                        <option value="fourth_year" {{ $enrollment->year_level == 'fourth_year' ? 'selected' : '' }}>Fourth Year</option>
                        <option value="5th_year" {{ $enrollment->year_level == '5th_year' ? 'selected' : '' }}>Fifth Year</option>
                        <option value="irregular" {{ $enrollment->year_level == 'irregular' ? 'selected' : '' }}>Irregular</option>
                    </select>
                </div>

                <!-- Category Selection -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">Category</label>
                    <select name="category" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <option value="old" {{ $enrollment->category == 'old' ? 'selected' : '' }}>Old</option>
                        <option value="new" {{ $enrollment->category == 'new' ? 'selected' : '' }}>New</option>
                        <option value="shifter" {{ $enrollment->category == 'shifter' ? 'selected' : '' }}>Shifter</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition">
                        Update 
                    </button>
                    <a href="{{ route('enrollments.index') }}" class="bg-red-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
