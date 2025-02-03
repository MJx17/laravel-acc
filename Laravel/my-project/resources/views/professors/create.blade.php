<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Professor') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Add Professor</h1>

        <form action="{{ route('professors.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="user_id" class="block font-medium">User ID</label>
                <input type="text" name="user_id" id="user_id" value="{{ old('user_id') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="surname" class="block font-medium">Surname</label>
                <input type="text" name="surname" id="surname" value="{{ old('surname') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('surname')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="first_name" class="block font-medium">First Name</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="middle_name" class="block font-medium">Middle Name (Optional)</label>
                <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('middle_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sex" class="block font-medium">Sex</label>
                <input type="text" name="sex" id="sex" value="{{ old('sex') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('sex')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="contact_number" class="block font-medium">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('contact_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="designation" class="block font-medium">Designation</label>
                <input type="text" name="designation" id="designation" value="{{ old('designation') }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('designation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

           

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Save
            </button>
        </form>
    </div>
</x-app-layout>
