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
            <table class="table-auto w-full divide-y -collapse  -gray-300">
                <thead class="bg-gray-200 text-left">
                    <tr>
                        <th class=" px-6 py-3">#</th>
                        <th class=" px-6 py-3">Name</th>
                        <th class=" px-6 py-3">Email</th>
                        <th class=" px-6 py-3">Mobile</th>
                        <th class=" px-6 py-3">Year Level</th>
                        <th class=" px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-100">
                            <td class=" px-6 py-3">{{ $loop->iteration }}</td>
                            <td class=" px-6 py-3">{{ $student->first_name }} {{ $student->surname }}</td>
                            <td class=" px-6 py-3">{{ $student->email_address }}</td>
                            <td class=" px-6 py-3">{{ $student->mobile_number }}</td>
                            <td class=" px-6 py-3">{{ $student->year_level }}</td>
                            <td class=" px-6 py-3">
                                <!-- Example action buttons -->
                                <a href="{{ route('student.edit', $student->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a> |
                                <a href="{{ route('student.show', $student->id) }}" class="text-green-500 hover:text-green-700">View</a>
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
