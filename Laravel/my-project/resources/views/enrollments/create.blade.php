<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Enrollment') }}
        </h2>
    </x-slot>

                    <div class="container mx-auto py-6">
                    <div class="min-w-[600px] sm:max-w-[300px] w-full mx-auto bg-white p-6 rounded-lg shadow-md">
                        <form action="{{ route('enrollments.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">{{ __('Student') }}</label>
                <select name="student_id" id="student_id" class="form-control w-full @error('student_id') border-red-500 @enderror">
                    <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>{{ __('Select Student') }}</option>
                    @if($students->isEmpty())
                        <!-- Show a fallback message if there are no students -->
                        <option value="" disabled>{{ __('No students available') }}</option>
                    @else
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->fullname }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('student_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="course_id" class="block text-sm font-medium text-gray-700">{{ __('Course') }}</label>
                <select name="course_id" id="course_id" class="form-control w-full @error('course_id') border-red-500 @enderror">
                    <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>{{ __('Select Course') }}</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="semester_id" class="block text-sm font-medium text-gray-700">{{ __('Semester') }}</label>
                <select name="semester_id" id="semester_id" class="form-control w-full @error('semester_id') border-red-500 @enderror">
                    <option value="" disabled {{ old('semester_id') ? '' : 'selected' }}>{{ __('Select Semester') }}</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                            {{ $semester->semester . ' semester' }}
                        </option>
                    @endforeach
                </select>
                @error('semester_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

                
                 <!-- Year Level -->
                 <div class="mb-4">
                            <label for="year_level" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Year Level</label>
                            <select name="year_level" id="year_level" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm">
                                <option value="" disabled selected>Select Year Level</option>
                                <option value="1st_year">1st Year</option>
                                <option value="2nd_year">2nd Year</option>
                                <option value="3rd_year">3rd Year</option>
                                <option value="4th_year">4th Year</option>
                                <option value="5th_year">5th Year</option>
                                <option value="irregular">Irregular</option>
                            </select>
                        </div>
    

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('Create Enrollment') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
