<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Professor Details
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-4">
        <!-- Responsive Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Section: Compact Professor Profile -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center text-center border-l-4 border-blue-500 lg:col-span-1 h-fit">
                <div class="w-24 h-24 bg-indigo-500 text-white flex items-center justify-center rounded-full text-3xl mb-4 shadow-lg">
                    🎓 <!-- Placeholder avatar -->
                </div>
                <h1 class="text-xl font-bold text-gray-900">{{ $professor->first_name }} {{ $professor->surname }}</h1>
                <p class="text-gray-500 text-sm">{{ $professor->designation }}</p>

                <div class="mt-4 text-gray-700 text-left w-full space-y-2">
                    <p class="flex items-center">
                        📧 <span class="ml-2 text-sm">{{ $professor->email }}</span>
                    </p>
                    <p class="flex items-center">
                        📞 <span class="ml-2 text-sm">{{ $professor->contact_number }}</span>
                    </p>
                </div>
            </div>
            
            <!-- Right Section: Subjects & Enrollments -->
            <div class="lg:col-span-2 bg-white shadow-lg rounded-lg p-6 ">
            <h3 class="text-xl font-semibold mb-4">📚 Assigned Subjects</h3>
                
                <!-- Search Bar -->
                <div x-data="{ search: '' }">
                    <input 
                        type="text" 
                        placeholder="Search subjects..." 
                        class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 mb-4"
                        x-model="search"
                    />

                    <!-- Subjects Table -->
                    <div class="overflow-x-auto h-[800px] overflow-y-auto scrollbar-hide">
                        <table class="w-full border-collapse ">
                            <thead class="bg-gray-200 text-left">
                                <tr>
                                    <th class="px-4 py-2">Subject</th>
                                    <th class="px-4 py-2">Day</th>
                                    <th class="px-4 py-2">Time</th>
                                    <th class="px-4 py-2">Students</th>
                                    <th class="px-4 py-2">Enrolled</th>
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
                                        <td class="px-4 py-2">{{ $subject->formatted_days }}</td>

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
                                                    Show
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
    </div>

    <!-- Alpine.js (Required for Dropdown & Search) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
