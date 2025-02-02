<!-- resources/views/students/enroll.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enroll Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <h3 class="text-2xl mb-4">Enroll Student in Subject</h3>

        <form action="{{ route('students.subjects.enroll', ['studentId' => $student->id, 'subjectId' => $subject->id]) }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="form-select block w-full mt-2 p-2 rounded-md border-gray-300">
                    <option value="enrolled" selected>Enrolled</option>
                    <option value="dropped">Dropped</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks (optional)</label>
                <textarea name="remarks" id="remarks" class="form-textarea block w-full mt-2 p-2 rounded-md border-gray-300" placeholder="Enter remarks (optional)"></textarea>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Enroll</button>
        </form>
    </div>
</x-app-layout>
