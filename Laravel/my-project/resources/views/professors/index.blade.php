<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Professors') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">All Professors</h1>
            <a href="{{ route('professors.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Add New Professor
            </a>
        </div>

        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-300">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">User ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Designation</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($professors as $professor)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $professor->user_id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            {{ $professor->first_name }} {{ $professor->middle_name }} {{ $professor->surname }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $professor->email }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $professor->designation }}</td>
                       
                        <td class="px-4 py-2 text-sm">
                            <a href="{{ route('professors.edit', $professor->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('professors.destroy', $professor->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $professors->links() }}
        </div>
    </div>
</x-app-layout>
