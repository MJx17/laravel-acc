<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Subjects List') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6">
        
        <!-- Create Button -->
        <div class="mb-4">
            <a href="{{ route('subjects.create') }}" 
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                Create New Subject
            </a>
        </div>

        <!-- Subjects Table -->
        <div class="overflow-x-auto shadow-xl sm:rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subjects as $subject)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $subject->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $subject->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('subjects.show', $subject->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('subjects.edit', $subject->id) }}" class="text-yellow-600 hover:text-yellow-900 ml-4">Edit</a>
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="inline-block ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this subject?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                No subjects available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $subjects->links() }}
        </div>
    </div>

    @if(session('success'))
    @endif

</x-app-layout>
