<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Subject') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('subjects.store') }}">
                        @csrf
                        
                        <!-- Subject Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Subject Code -->
                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700">Subject Code</label>
                            <input type="text" name="code" id="code" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('code') }}" required>
                            @error('code')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Semester -->
                        <div class="mb-4">
                            <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                            <select name="semester_id" id="semester_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                                <option value="">Select Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->semester  }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Year Level -->
                        <div class="flex flex-col">
                        <select id="year_level" name="year_level" class="mt-2 p-2 border border-gray-300 rounded-md">
                            <option value="" disabled selected>Select Year Level</option> <!-- Default placeholder -->
                            <option value="first_year">First Year</option>
                            <option value="second_year">Second Year</option>
                            <option value="third_year">Third Year</option>
                            <option value="fourth_year">Fourth Year</option>
                            <option value="5th_year">Fifth Year</option>
                            <option value="irregular">Irregular</option>
                        </select>
                    </div>



                        <!-- Prerequisite -->
                        <div class="mb-4">
                            <label for="prerequisite_id" class="block text-sm font-medium text-gray-700">Prerequisite</label>
                            <select name="prerequisite_id" id="prerequisite_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                                <option value="">None</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('prerequisite_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prerequisite_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Fee -->
                        <div class="mb-4">
                            <label for="fee" class="block text-sm font-medium text-gray-700">Fee</label>
                            <input type="number" name="fee" id="fee" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('fee') }}" required>
                            @error('fee')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Units -->
                        <div class="mb-4">
                            <label for="units" class="block text-sm font-medium text-gray-700">Units</label>
                            <input type="number" name="units" id="units" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ old('units') }}" step="0.1" min="0.1" max="10" required>
                            @error('units')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Courses -->
                       <!-- Courses -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Courses</label>
                                <div class="mt-2">
                                    @foreach($courses as $course)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="course_ids[]" value="{{ $course->id }}" 
                                                class="mr-2" 
                                                {{ in_array($course->id, old('course_ids', [])) ? 'checked' : '' }}>
                                            <label for="course_ids[]" class="text-sm text-gray-700">{{ $course->course_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('course_ids')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>


                        <!-- Professor -->
                        <div class="mb-4">
                            <label for="professor_id" class="block text-sm font-medium text-gray-700">Professor</label>
                            <select name="professor_id" id="professor_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                                <option value="">Select Professor</option>
                                @foreach($professors as $professor)
                                    <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                                        {{ $professor->user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('professor_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                                Create Subject
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
