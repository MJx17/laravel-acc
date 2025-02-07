<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Enrollment') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
            <form method="POST" action="{{ route('enrollments.store') }}">
                @csrf

                <!-- Student Selection -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Student') }}</label>
                    <select name="student_id" required class="w-full border rounded-lg p-2">
                        <option value="">{{ __('Select Student') }}</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->fullname }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Course Selection -->
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Course') }}</label>
                    <select name="course_id" required class="w-full border rounded-lg p-2">
                        <option value="">{{ __('Select Course') }}</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester Selection -->
                <div class="mb-4">
                    <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester_id" id="semester_id" class="form-control w-full">
                        <option value="" disabled selected>Select Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>{{ $semester->semester }} semester</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Level -->
                <div class="flex flex-col">
                        <select id="year_level" name="year_level" class="mt-2 p-2 border border-gray-300 rounded-md">
                            <option value="" disabled selected>Select Year Level</option> <!-- Default placeholder -->
                            <option value="first_year">First Year</option>
                            <option value="second_year">Second Year</option>
                            <option value="third_year">Third Year</option>
                            <option value="fourth_year">Fourth Year</option>
                            <option value="5th_year">Fifth Year</option>
                            <option value="irregular">Irregular</option>
                        </select>
                    </div>
                    
                <!-- Subjects Selection -->
                <!-- Subjects Selection -->
                    <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Subjects') }}</label>
                    <div id="subjects-container" class="grid grid-cols-2 gap-2">
                        <p class="text-gray-500">Select a course, semester, and year level to see subjects.</p>
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg">
                        {{ __('Enroll Student') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const courseSelect = document.querySelector('select[name="course_id"]');
        const semesterSelect = document.querySelector('select[name="semester_id"]');
        const yearLevelSelect = document.querySelector('select[name="year_level"]');
        const subjectsContainer = document.getElementById('subjects-container');

        function fetchSubjects() {
            const courseId = courseSelect.value;
            const semesterId = semesterSelect.value;
            const yearLevel = yearLevelSelect.value;

            if (!courseId || !semesterId || !yearLevel) {
                subjectsContainer.innerHTML = ''; // Clear subjects if selections are incomplete
                return;
            }

            fetch(`{{ route('get.subjects') }}?course_id=${courseId}&semester_id=${semesterId}&year_level=${yearLevel}`)
                .then(response => response.json())
                .then(data => {
                    subjectsContainer.innerHTML = '';
                    if (data.length === 0) {
                        subjectsContainer.innerHTML = '<p class="text-gray-500">No subjects available.</p>';
                    } else {
                        data.forEach(subject => {
                            const label = document.createElement('label');
                            label.className = 'inline-flex items-center';

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'subjects[]';
                            checkbox.value = subject.id;
                            checkbox.className = 'form-checkbox';

                            const span = document.createElement('span');
                            span.className = 'ml-2';
                            span.textContent = subject.name;

                            label.appendChild(checkbox);
                            label.appendChild(span);
                            subjectsContainer.appendChild(label);
                        });
                    }
                })
                .catch(error => console.error('Error fetching subjects:', error));
        }

        courseSelect.addEventListener('change', fetchSubjects);
        semesterSelect.addEventListener('change', fetchSubjects);
        yearLevelSelect.addEventListener('change', fetchSubjects);
    });
</script>

</x-app-layout>
