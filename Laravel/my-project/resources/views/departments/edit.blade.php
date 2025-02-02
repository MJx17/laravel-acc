<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Department') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Department</h1>

        <form action="{{ route('departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block font-medium">Department Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" 
                    class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Update
            </button>
        </form>
    </div>
</x-app-layout>
