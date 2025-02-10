<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Professor Details
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <!-- Parent Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <!-- Professor Details -->
            <div class="mb-6 border-b pb-4">
                <h1 class="text-2xl font-bold">{{ $professor->first_name }} {{ $professor->surname }}</h1>
                <p class="text-gray-700">{{ $professor->designation }}</p>
                <p class="text-gray-700">Email: {{ $professor->email }}</p>
                <p class="text-gray-700">Contact: {{ $professor->contact_number }}</p>
            </div>

            <!-- Subjects Table -->
            <div x-data="{ search: '' }">
                <!-- Search Bar -->
                <input 
                    type="text" 
                    placeholder="Search subjects..." 
                    class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 mb-4"
                    x-model="search"
                />

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-200 text-left">
                            <tr>
                                <th class="px-4 py-2">Subject</th>
                                <th class="px-4 py-2">Day</th>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Students</th>
                                <th class="px-4 py-2">Enrolled Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                                <tr 
                                    class="bg-gray-50 even:bg-gray-100"
                                    x-show="$el.textContent.toLowerCase().includes(search.toLowerCase())"
                                >
                                    <!-- Subject Name -->
                                    <td class="px-4 py-2 font-semibold">{{ $subject->name }}</td>
                                    
                                    <!-- Day -->
                                    <td class="px-4 py-2">
                                        {{ $subject->formatted_days }}
                                    </td>


                                    <!-- Time -->
                                    <td class="px-4 py-2">{{ $subject->start_time }} - {{ $subject->end_time }}</td>

                                    <!-- Student Count -->
                                    <td class="px-4 py-2 text-center">{{ $subject->students_count }}</td>
                                    
                                    <!-- Students Dropdown -->
                                    <td class="px-4 py-2">
                                        <div x-data="{ open: false, searchStudent: '' }">
                                            <button 
                                                @click="open = !open" 
                                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                            >
                                                Show Students
                                            </button>

                                            <div x-show="open" class="mt-2 p-2 bg-white shadow rounded-md border border-gray-300">
                                                <!-- Search for Students -->
                                                <input 
                                                    type="text" 
                                                    placeholder="Search students..." 
                                                    class="w-full p-1 border rounded-md mb-2"
                                                    x-model="searchStudent"
                                                />
                                                <ul>
                                                    @foreach($subject->students as $student)
                                                        <li 
                                                            class="py-1 px-2 border-b text-gray-800"
                                                            x-show="$el.textContent.toLowerCase().includes(searchStudent.toLowerCase())"
                                                        >
                                                            {{ $student->fullname }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js (Required for Dropdown & Search) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
