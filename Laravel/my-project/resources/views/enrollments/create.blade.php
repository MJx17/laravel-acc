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
                <select name="student_id" id="student_id" class="mt-1 block w-full form-select" required>
                    <option value="">Select a student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Semester -->
            <div class="mb-4">
                <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                <select name="semester_id" id="semester_id" class="mt-1 block w-full form-select" required>
                    <option value="">Select a semester</option>
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Course -->
            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                <select name="course_id" id="course_id" class="mt-1 block w-full form-select" required>
                    <option value="">Select a course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year Level -->
            <div class="mb-4">
                <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                <input type="number" name="year_level" id="year_level" class="mt-1 block w-full form-input" required>
            </div>

            <!-- Subjects Dual Listbox -->
            <div class="mb-4">
                <label for="subjects" class="block text-sm font-medium text-gray-700">Subjects</label>
                <div class="d-flex justify-content-between">
                    <!-- Available Subjects -->
                    <div class="w-50 pr-2">
                        <label class="block text-sm font-medium text-gray-700">Available Subjects</label>
                        <select name="available_subjects[]" id="available_subjects" class="form-select" multiple size="10" required>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons to move items between lists -->
                    <div class="w-25 d-flex flex-column justify-content-center align-items-center">
                        <button type="button" id="move_right" class="btn btn-primary mb-2" onclick="moveItem('right')">></button>
                        <button type="button" id="move_left" class="btn btn-primary mb-2" onclick="moveItem('left')"><</button>
                    </div>

                    <!-- Selected Subjects -->
                    <div class="w-50 pl-2">
                        <label class="block text-sm font-medium text-gray-700">Selected Subjects</label>
                        <select name="subjects[]" id="selected_subjects" class="form-select" multiple size="10" required>
                        </select>
                    </div>
                </div>
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

    <script>
        function moveItem(direction) {
            var availableSubjects = document.getElementById("available_subjects");
            var selectedSubjects = document.getElementById("selected_subjects");
            var selectedOption;

            if (direction === 'right') {
                // Move from available to selected
                Array.from(availableSubjects.selectedOptions).forEach(option => {
                    selectedSubjects.add(option);
                });
            } else if (direction === 'left') {
                // Move from selected to available
                Array.from(selectedSubjects.selectedOptions).forEach(option => {
                    availableSubjects.add(option);
                });
            }
        }
    </script>
</x-app-layout>
