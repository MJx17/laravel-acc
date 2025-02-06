<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Surname</label>
                    <input type="text" name="surname" value="{{ old('surname', $student->surname) }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $student->middle_name) }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Sex</label>
                    <select name="sex" class="w-full p-2 border border-gray-300 rounded">
                        <option value="Male" {{ $student->sex == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $student->sex == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $student->sex == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', $student->dob) }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Email Address</label>
                    <input type="email" name="email_address" value="{{ old('email_address', $student->email_address) }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Mobile Number</label>
                    <input type="text" name="mobile_number" value="{{ old('mobile_number', $student->mobile_number) }}" class="w-full p-2 border border-gray-300 rounded">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200">Image</label>
                    <input type="file" name="image" class="w-full p-2 border border-gray-300 rounded">
                    @if($student->image)
                        <img src="{{ asset('storage/' . $student->image) }}" class="mt-2 h-20" alt="Student Image">
                    @endif
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>