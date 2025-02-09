<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Enrollment') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-12 px-6 sm:px-8 lg:px-10">
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Enroll a Student</h2>
        
        <form method="POST" action="{{ route('enrollments.store') }}" class="space-y-6">
            @csrf

            <!-- Student Selection -->
            <div>
                <select name="student_id" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <option value="" disabled selected>Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->fullname }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Course Selection -->
            <div>
                <select name="course_id" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <option value="" disabled selected>Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Semester Selection -->
            <div>
                <select name="semester_id" id="semester_id" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <option value="" disabled selected>Select Semester</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                            {{ $semester->semester }} Semester
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Year Level Selection -->
            <div>
                <select id="year_level" name="year_level" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <option value="" disabled selected>Select Year Level</option>
                    <option value="first_year">First Year</option>
                    <option value="second_year">Second Year</option>
                    <option value="third_year">Third Year</option>
                    <option value="fourth_year">Fourth Year</option>
                    <option value="5th_year">Fifth Year</option>
                    <option value="irregular">Irregular</option>
                </select>
            </div>

            <!-- Subjects Selection -->
            <div>
                <div id="subjects-container" class="grid grid-cols-1 gap-3 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400">Select a course, semester, and year level to see subjects.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition">
                    Enroll Student
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

                if (Object.keys(data).length === 0) {
                    subjectsContainer.innerHTML = '<p class="text-gray-500">No subjects available.</p>';
                } else {
                    Object.keys(data).forEach(year => {
                        // Container for each year level
                        const yearContainer = document.createElement('div');
                        yearContainer.className = 'mb-4 border-b pb-2'; // Add spacing and underline for separation

                        // Year level header
                        const yearHeader = document.createElement('h3');
                        yearHeader.textContent = year.replace('_', ' ').toUpperCase();
                        yearHeader.className = 'text-lg font-semibold mb-2';

                        // Subject list container (to keep subjects properly aligned)
                        const subjectList = document.createElement('div');
                        subjectList.className = 'grid grid-cols-2 gap-2'; // Makes subjects align in two columns

                        data[year].forEach(subject => {
                            const label = document.createElement('label');
                            label.className = 'flex items-center space-x-2'; // Proper spacing

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'subjects[]';
                            checkbox.value = subject.id;
                            checkbox.className = 'form-checkbox';

                            const span = document.createElement('span');
                            span.textContent = subject.name;

                            label.appendChild(checkbox);
                            label.appendChild(span);
                            subjectList.appendChild(label);
                        });

                        // Append header and subject list to container
                        yearContainer.appendChild(yearHeader);
                        yearContainer.appendChild(subjectList);
                        subjectsContainer.appendChild(yearContainer);
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
