<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Course Subjects') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Courses and Subjects</h3>

            <div class="space-y-4">
                @foreach ($groupedCourses as $courseName => $courseSubjects)
                    <div class="border-b border-gray-300 pb-4">
                        <h4 class="text-lg font-medium text-gray-800">{{ $courseName }}</h4>

                        <ul class="mt-2 space-y-2 list-disc pl-5">
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
    </div>
</x-app-layout>
