<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Subject Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6">
        <div class="bg-white shadow-lg sm:rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Subject Name -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Subject Name:</h3>
                    <p class="text-gray-600">{{ $subject->name }}</p>
                </div>

                <!-- Subject Code -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Subject Code:</h3>
                    <p class="text-gray-600">{{ $subject->code }}</p>
                </div>

                <!-- Course Name -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Course:</h3>
                    <p class="text-gray-600">{{ $subject->course ? $subject->course->course_name : 'N/A' }}</p>
                </div>

                <!-- Professor Name -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Professor:</h3>
                    <p class="text-gray-600">{{ $subject->professor ? $subject->professor->full_name : 'N/A' }}</p>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Description:</h3>
                    <p class="text-gray-600">{{ $subject->description ?? 'No description available' }}</p>
                </div>

                <!-- Block -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Block:</h3>
                    <p class="text-gray-600">{{ $subject->block ?? 'N/A' }}</p>
                </div>

                <!-- Semester -->
                <p class="text-gray-600">{{ $subject->semester ? $subject->semester->semester . ' - ' . $subject->semester->academic_year : 'N/A' }}</p>


                <!-- Year Level -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Year Level:</h3>
                    <p class="text-gray-600">{{ $subject->year_level }} Year</p>
                </div>

                <!-- Prerequisite -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Prerequisite:</h3>
                    <p class="text-gray-600">{{ $subject->prerequisite ? $subject->prerequisite->name : 'None' }}</p>
                </div>

                <!-- Fee -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Fee:</h3>
                    <p class="text-gray-600">{{ number_format($subject->fee, 2) }} PHP</p>
                </div>

                <!-- Units -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Units:</h3>
                    <p class="text-gray-600">{{ $subject->units }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('subjects.index') }}" 
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
