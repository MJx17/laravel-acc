<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Subject') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6">
        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Subject Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $subject->name) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                        required>
                    @error('name') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Subject Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Subject Code</label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        value="{{ old('code', $subject->code) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                        required>
                    @error('code') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Course -->
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                    <select 
                        id="course_id" 
                        name="course_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        <option value="">Select a Course</option>
                        @foreach($courses as $course)
                            <option 
                                value="{{ $course->id }}" 
                                {{ old('course_id', $subject->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Professor -->
                <div>
                    <label for="professor_id" class="block text-sm font-medium text-gray-700">Professor</label>
                    <select 
                        id="professor_id" 
                        name="professor_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        <option value="">Select a Professor</option>
                        @foreach($professors as $professor)
                            <option 
                                value="{{ $professor->id }}" 
                                {{ old('professor_id', $subject->professor_id) == $professor->id ? 'selected' : '' }}>
                                {{ $professor->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('professor_id') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">{{ old('description', $subject->description) }}</textarea>
                    @error('description') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Block -->
                <div>
                    <label for="block" class="block text-sm font-medium text-gray-700">Block</label>
                    <input 
                        type="text" 
                        id="block" 
                        name="block" 
                        value="{{ old('block', $subject->block) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    @error('block') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Semester -->
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
                    <input 
                        type="number" 
                        id="year_level" 
                        name="year_level" 
                        value="{{ old('year_level', $subject->year_level) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                        required>
                    @error('year_level') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Prerequisite -->
                <div>
                    <label for="prerequisite_id" class="block text-sm font-medium text-gray-700">Prerequisite</label>
                    <select 
                        id="prerequisite_id" 
                        name="prerequisite_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        <option value="">Select Prerequisite</option>
                        @foreach($subjects as $prerequisite)
                            <option 
                                value="{{ $prerequisite->id }}" 
                                {{ old('prerequisite_id', $subject->prerequisite_id) == $prerequisite->id ? 'selected' : '' }}>
                                {{ $prerequisite->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('prerequisite_id') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Fee -->
                <div>
                    <label for="fee" class="block text-sm font-medium text-gray-700">Fee</label>
                    <input 
                        type="number" 
                        id="fee" 
                        name="fee" 
                        value="{{ old('fee', $subject->fee) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                        step="0.01" required>
                    @error('fee') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Units -->
                <div>
                    <label for="units" class="block text-sm font-medium text-gray-700">Units</label>
                    <input 
                        type="number" 
                        id="units" 
                        name="units" 
                        value="{{ old('units', $subject->units) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" 
                        required>
                    @error('units') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">

                     <a href="{{ route('subjects.index')}}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300">
                        Cancel
                    </a>
                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Subject
                </button>
             
            </div>
        </form>
    </div>
</x-app-layout>
