<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Student Management</h1>

        <!-- Table for students -->
        <div class="overflow-x-auto shadow-sm rounded-lg">
            <table class="table-auto w-full divide-y divide-gray-300">
                <thead class="bg-gray-200 text-left">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Mobile</th>
                        <th class="px-6 py-3">Year Level</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $student->first_name }} {{ $student->surname }}</td>
                            <td class="px-6 py-3">{{ $student->email_address }}</td>
                            <td class="px-6 py-3">{{ $student->mobile_number }}</td>
                            <td class="px-6 py-3">{{ $student->year_level }}</td>
                            <td class="px-6 py-3">
                                <!-- Styled action buttons -->
                                <a href="{{ route('student.edit', $student->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-200">Edit</a>
                                <a href="{{ route('student.show', $student->id) }}" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-700 transition duration-200">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }} <!-- Display pagination links -->
        </div>
    </div>
</x-app-layout>
