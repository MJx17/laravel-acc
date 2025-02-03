<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Professor') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Professor</h1>

            <form action="{{ route('professors.update', $professor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Card Section for Form Inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- User ID -->
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">User ID</label>
                        <input type="text" name="user_id" id="user_id" value="{{ old('user_id', $professor->user_id) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Surname -->
                    <div class="mb-4">
                        <label for="surname" class="block text-sm font-medium text-gray-700">Surname</label>
                        <input type="text" name="surname" id="surname" value="{{ old('surname', $professor->surname) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('surname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- First Name -->
                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $professor->first_name) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Middle Name (Optional) -->
                    <div class="mb-4">
                        <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name (Optional)</label>
                        <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $professor->middle_name) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('middle_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sex -->
                    <div class="mb-4">
                        <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                        <input type="text" name="sex" id="sex" value="{{ old('sex', $professor->sex) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('sex')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div class="mb-4">
                        <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $professor->contact_number) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('contact_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $professor->email) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Designation -->
                    <div class="mb-4">
                        <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
                        <input type="text" name="designation" id="designation" value="{{ old('designation', $professor->designation) }}" 
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('designation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end space-x-4">
    <!-- Update Button -->
                <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-500">
                    Update
                </button>

                <!-- Cancel Button -->

            <a href="{{ route('professors.index') }}" 
                 class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-500">
                    Cancel
                </a>
            </div>


            </form>
        </div>
    </div>
</x-app-layout>
