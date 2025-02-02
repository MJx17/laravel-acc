<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Course</h1>

        <form action="{{ route('courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="course_code" class="block font-medium">Course Code</label>
                <input type="text" name="course_code" id="course_code" value="{{ old('course_code', $course->course_code) }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('course_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="course_name" class="block font-medium">Course Name</label>
                <input type="text" name="course_name" id="course_name" value="{{ old('course_name', $course->course_name) }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('course_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="department_id" class="block font-medium">Department</label>
                <select name="department_id" id="department_id" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" 
                            {{ old('department_id', $course->department_id) == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium">Description</label>
                <textarea name="description" id="description" rows="3" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="units" class="block font-medium">Units</label>
                <input type="number" name="units" id="units" value="{{ old('units', $course->units) }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('units')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Update Course
            </button>
        </form>
    </div>
</x-app-layout>
