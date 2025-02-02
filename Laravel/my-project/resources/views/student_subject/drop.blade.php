<!-- resources/views/students/drop.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Drop Enrollment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <h3 class="text-2xl mb-4">Drop Student from Subject</h3>

        <form action="{{ route('students.subjects.drop', ['studentId' => $student->id, 'subjectId' => $subject->id]) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="alert alert-warning p-4 mb-4 bg-yellow-100 text-yellow-700 rounded-md">
                Are you sure you want to drop this student from the subject?
            </div>

            <button type="submit" class="btn btn-danger px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700">Drop Student</button>
        </form>
    </div>
</x-app-layout>
