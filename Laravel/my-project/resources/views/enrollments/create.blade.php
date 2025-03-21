<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Enrollment') }}
        </h2>
    </x-slot>


<div class="max-w-5xl mx-auto py-12 px-6 sm:px-8 lg:px-10">
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-8">
        <form method="POST" action="{{ route('enrollments.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @csrf

            <!-- Student & Course Selection -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Student & Course</h3>
                <div class="grid grid-cols-1 gap-4">
                    <select name="student_id" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->fullname }}</option>
                        @endforeach
                    </select>

                    <select id="category" name="category" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select Category</option>
                        <option value="old">Old</option>
                        <option value="new">New</option>
                        <option value="shifter">Shifter</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <select name="semester_id" id="semester_id" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->semester }} Semester
                            </option>
                        @endforeach
                    </select>

                    <select id="year_level" name="year_level" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select Year Level</option>
                        <option value="first_year">First Year</option>
                        <option value="second_year">Second Year</option>
                        <option value="third_year">Third Year</option>
                        <option value="fourth_year">Fourth Year</option>
                        <option value="5th_year">Fifth Year</option>
                        <option value="irregular">Irregular</option>
                    </select>
                </div>

                <select name="course_id" required class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Tuition Fees Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-white">Tuition & Fees</h3>

                <div class="grid grid-cols-1 gap-4">
                    <input type="number" name="tuition_fee" id="tuition_fee" placeholder="Tuition Fee" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <input type="number" name="lab_fee" id="lab_fee" placeholder="Lab Fee" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <input type="number" name="miscellaneous_fee" id="miscellaneous_fee" placeholder="Miscellaneous Fee" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <input type="number" name="other_fee" id="other_fee" placeholder="Other Fee" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <input type="number" name="discount" id="discount" placeholder="Discount" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                <input type="number" name="initial_payment" id="initial_payment" placeholder="Initial Payment" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Subjects Container - Now Full Width -->
            <div id="subjects-container" class="col-span-1 md:col-span-2 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">
                    Select a course, semester, and year level to see subjects.
                </p>
            </div>


            <div class="cols-span-1 md:col-span-2  flex-1 ">
               
                    @include('partials.financial')
                
            </div>


            <!-- Submit & Cancel Buttons -->
            <div class="col-span-1 md:col-span-2 flex justify-end gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition">
                    Enroll
                </button>
                <a href="{{ route('enrollments.index') }}" class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-lg transition">
                    Cancel
                </a>
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
                    const wrapper = document.createElement('div');
                    wrapper.className = 'grid grid-cols-1 md:grid-cols-2 gap-4'; // Two columns on larger screens

                    Object.keys(data).forEach(year => {
                        // Year container (flex item)
                        const yearContainer = document.createElement('div');
                        yearContainer.className = 'border p-4 rounded-lg bg-white dark:bg-gray-900 shadow';

                        // Year level header
                        const yearHeader = document.createElement('h3');
                        yearHeader.textContent = year.replace('_', ' ').toUpperCase();
                        yearHeader.className = 'text-lg font-semibold mb-2';

                        // Subject list container
                        const subjectList = document.createElement('div');
                        subjectList.className = 'flex flex-col gap-2';

                        data[year].forEach(subject => {
                            const label = document.createElement('label');
                            label.className = 'flex items-center justify-between w-full';

                            const span = document.createElement('span');
                            span.textContent = subject.name;

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'subjects[]';
                            checkbox.value = subject.id;
                            checkbox.className = 'form-checkbox';

                            label.appendChild(span);
                            label.appendChild(checkbox);
                            subjectList.appendChild(label);
                        });

                        // Append header and subject list to container
                        yearContainer.appendChild(yearHeader);
                        yearContainer.appendChild(subjectList);
                        wrapper.appendChild(yearContainer);
                    });

                    subjectsContainer.appendChild(wrapper);
                }
            })
            .catch(error => console.error('Error fetching subjects:', error));
    }

    courseSelect.addEventListener('change', fetchSubjects);
    semesterSelect.addEventListener('change', fetchSubjects);
    yearLevelSelect.addEventListener('change', fetchSubjects);
});



data[year].forEach(subject => {
    const label = document.createElement('label');
    label.className = 'flex items-center justify-start gap-2 w-full'; // Keeps text left & checkbox right

    const span = document.createElement('span');
    span.textContent = subject.name;

    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.name = 'subjects[]';
    checkbox.value = subject.id;
    checkbox.className = 'form-checkbox ml-auto'; // Pushes checkbox to the right

    label.appendChild(span);
    label.appendChild(checkbox);
    subjectList.appendChild(label);
});


</script>


</x-app-layout>
