<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Enrollment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 flex justify-center">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 w-full max-w-xl">
            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Enrollment</h1>

            <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Student -->
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Student</label>
                    <select name="student_id" id="student_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                    <label for="semester_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Semester</label>
                    <select name="semester_id" id="semester_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                    <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course</label>
                    <select name="course_id" id="course_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                    <label for="year_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year Level</label>
                    <input type="number" name="year_level" id="year_level" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('year_level', $enrollment->year_level) }}" required>
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end gap-2">
                  
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Update
                    </button>
                    <a href="{{ route('enrollments.index') }}" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
