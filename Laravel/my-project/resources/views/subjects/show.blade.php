<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            📚 {{ __('Subject Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 max-w-xl px-4">
        <div class="bg-white shadow-md rounded-xl p-6">
            <div class="flex flex-col gap-4"> 
                <!-- Subject Name -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">📖 Subject Name</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ $subject->name }}</p>
                </div>

                <!-- Subject Code -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">🔢 Subject Code</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ $subject->code }}</p>
                </div>

             
                <!-- Professor Name -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">👨‍🏫 Professor</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ $subject->professor ? $subject->professor->full_name : 'N/A' }}</p>
                </div>

          

                <!-- Block -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">🏢 Block</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ $subject->block ?? 'N/A' }}</p>
                </div>

                <!-- Semester -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">📆 Semester</h3>
                    <p class="text-base sm:text-lg text-gray-600">
                        {{ $subject->semester ? $subject->semester->semester . ' - ' . $subject->semester->academic_year : 'N/A' }}
                    </p>
                </div>

                <!-- Year Level -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">🎓 Year Level</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ $subject->year_level }}</p>
                </div>

                <!-- Prerequisite -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">✅ Prerequisite</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ $subject->prerequisite ? $subject->prerequisite->name : 'None' }}</p>
                </div>

                <!-- Fee -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">💰 Fee</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ number_format($subject->fee, 2) }} PHP</p>
                </div>

                <!-- Units -->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">📏 Units</h3>
                    <p class="text-base sm:text-lg text-gray-600">{{ $subject->units }}</p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('subjects.index') }}" 
                    class="inline-flex items-center px-5 py-3 text-lg font-medium text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 transition">
                    🔙 Back to List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
