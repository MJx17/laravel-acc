<!-- resources/views/students/update-status.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Enrollment Status') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <h3 class="text-2xl mb-4">Update Student Enrollment Status</h3>

        <form action="{{ route('students.subjects.update-status', ['studentId' => $student->id, 'subjectId' => $subject->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="form-select block w-full mt-2 p-2 rounded-md border-gray-300">
                    <option value="enrolled" @if($pivot->status == 'enrolled') selected @endif>Enrolled</option>
                    <option value="completed" @if($pivot->status == 'completed') selected @endif>Completed</option>
                    <option value="dropped" @if($pivot->status == 'dropped') selected @endif>Dropped</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks (optional)</label>
                <textarea name="remarks" id="remarks" class="form-textarea block w-full mt-2 p-2 rounded-md border-gray-300">{{ $pivot->remarks }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Update Status</button>
        </form>
    </div>
</x-app-layout>
