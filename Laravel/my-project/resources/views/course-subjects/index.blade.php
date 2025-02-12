<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Course Subjects') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Courses and Subjects</h3>

            <!-- Course Selection Tabs -->
            <div class="flex space-x-4 mb-4" id="courseTabs">
                @foreach ($groupedCourses as $courseCode => $courseSubjects)
                    <button 
                        class="course-tab px-4 py-2 rounded-md transition duration-300 bg-gray-200 text-gray-700"
                        data-course="{{ $courseCode }}"
                    >
                        {{ $courseCode }}
                    </button>
                @endforeach
            </div>

            <!-- Shelves (Only Render Active Shelf) -->
            @foreach ($groupedCourses as $courseCode => $courseSubjects)
                <div class="course-shelf bg-white shadow-lg rounded-lg p-4 hidden" id="shelf-{{ $courseCode }}">
                    <h4 class="text-lg font-semibold text-gray-800 border-b pb-2">Course Code: {{ $courseCode }}</h4>

                    <ul class="mt-3 space-y-2">
                        @foreach ($courseSubjects as $courseSubject)
                            <li class="flex justify-between items-center bg-gray-100 p-2 rounded-md">
                                <span>{{ $courseSubject->subject->name }}</span>

                                <div class="flex space-x-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('course-subjects.edit', $courseSubject->id) }}" class="text-blue-500 hover:text-blue-700">
                                        Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('course-subjects.destroy', $courseSubject->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
   
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let tabs = document.querySelectorAll(".course-tab");
            let shelves = document.querySelectorAll(".course-shelf");

            // Function to show the selected course and hide others
            function showCourse(courseCode) {
                shelves.forEach(shelf => {
                    if (shelf.id === `shelf-${courseCode}`) {
                        shelf.classList.remove("hidden");
                    } else {
                        shelf.classList.add("hidden");
                    }
                });

                tabs.forEach(tab => {
                    if (tab.getAttribute("data-course") === courseCode) {
                        tab.classList.add("bg-blue-500", "text-white");
                        tab.classList.remove("bg-gray-200", "text-gray-700");
                    } else {
                        tab.classList.remove("bg-blue-500", "text-white");
                        tab.classList.add("bg-gray-200", "text-gray-700");
                    }
                });
            }

            // Add event listener to all course tabs
            tabs.forEach(tab => {
                tab.addEventListener("click", function () {
                    let courseCode = this.getAttribute("data-course");
                    showCourse(courseCode);
                });
            });

            // Show the first course by default
            if (tabs.length > 0) {
                showCourse(tabs[0].getAttribute("data-course"));
            }
        });
    </script>

</x-app-layout>
