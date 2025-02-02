<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Subject') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                
                <!-- Subject Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                    <input type="text" name="name" id="name" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Subject Code</label>
                    <input type="text" name="code" id="code" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('code') }}" required>
                    @error('code')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Course Selection -->
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                    <select id="course_id" name="course_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select a Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Professor Selection -->
                <div>
                    <label for="professor_id" class="block text-sm font-medium text-gray-700">Professor</label>
                    <select name="professor_id" id="professor_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select a professor</option>
                        @foreach($professors as $professor)
                            <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>{{ $professor->user->name }}</option>
                        @endforeach
                    </select>
                    @error('professor_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prerequisite Subject Selection -->
                <div>
                    <label for="prerequisite_id" class="block text-sm font-medium text-gray-700">Prerequisite Subject</label>
                    <select name="prerequisite_id" id="prerequisite_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select a prerequisite subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('prerequisite_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('prerequisite_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Semester Selection -->
                <div>
                    <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester_id" id="semester_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select a semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->semester }} - {{ $semester->academic_year }} 
                            </option>
                        @endforeach
                    </select>
                    @error('semester_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Year Level -->
                <div>
                    <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                    <input type="number" name="year_level" id="year_level" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('year_level') }}" required>
                    @error('year_level')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fee -->
                <div>
                    <label for="fee" class="block text-sm font-medium text-gray-700">Fee</label>
                    <input type="number" name="fee" id="fee" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('fee') }}" required>
                    @error('fee')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Units -->
                <div>
                    <label for="units" class="block text-sm font-medium text-gray-700">Units</label>
                    <input type="number" name="units" id="units" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('units') }}" min="0.1" max="10" step="0.1" required>
                    @error('units')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2 flex justify-end space-x-4">
                    <a href="{{ route('subjects.index') }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
