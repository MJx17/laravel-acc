<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enrollment Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6" x-data="{ activeTab: 'subjects' }">

                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-300 dark:border-gray-600 mb-4">
                    <button @click="activeTab = 'subjects'" 
                        :class="{ 'bg-gray-200 dark:bg-gray-700 font-semibold': activeTab === 'subjects' }"
                        class="px-4 py-2 flex-1 text-center hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        Subjects
                    </button>

                    <button @click="activeTab = 'fees'" 
                        :class="{ 'bg-gray-200 dark:bg-gray-700 font-semibold': activeTab === 'fees' }"
                        class="px-4 py-2 flex-1 text-center hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        Fees
                    </button>

                    <button @click="activeTab = 'payment'" 
                        :class="{ 'bg-gray-200 dark:bg-gray-700 font-semibold': activeTab === 'payment' }"
                        class="px-4 py-2 flex-1 text-center hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        Payment
                    </button>
                </div>

                <!-- Subjects Tab -->
                <div x-show="activeTab === 'subjects'">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Enrolled Subjects</h3>
                    @if($enrollment->subjects->isNotEmpty())
                        <ul class="list-disc list-inside text-gray-700 dark:text-gray-300">
                            @foreach ($enrollment->subjects as $subject)
                                <li>{{ $subject->name }} ({{ $subject->code }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No subjects enrolled.</p>
                    @endif
                </div>

                <!-- Fees Tab -->
                <div x-show="activeTab === 'fees'" class="mt-4">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-200">Tuition Fees Breakdown</h3>
                    @if($enrollment->fees)
                        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                            <thead class="bg-gray-200 dark:bg-gray-700">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Fee Type</th>
                                    <th class="border px-4 py-2 text-right">Amount (₱)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="border px-4 py-2">Tuition Fee</td> <td class="border px-4 py-2 text-right">{{ number_format($enrollment->fees->tuition_fee, 2) }}</td></tr>
                                <tr><td class="border px-4 py-2">Lab Fee</td> <td class="border px-4 py-2 text-right">{{ number_format($enrollment->fees->lab_fee, 2) }}</td></tr>
                                <tr><td class="border px-4 py-2">Miscellaneous Fee</td> <td class="border px-4 py-2 text-right">{{ number_format($enrollment->fees->miscellaneous_fee, 2) }}</td></tr>
                                <tr><td class="border px-4 py-2">Other Fee</td> <td class="border px-4 py-2 text-right">{{ number_format($enrollment->fees->other_fee, 2) }}</td></tr>
                                <tr><td class="border px-4 py-2">Discount</td> <td class="border px-4 py-2 text-right">-{{ number_format($enrollment->fees->discount, 2) }}</td></tr>
                            </tbody>
                            <tfoot class="bg-gray-200 dark:bg-gray-700">
                                <tr>
                                    <td class="border px-4 py-2 font-bold">Total Fees</td>
                                    <td class="border px-4 py-2 font-bold text-right">₱{{ number_format($totalFees, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Fees have not been set for this enrollment.</p>
                    @endif
                </div>


                <!-- Back Link -->
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('enrollments.index') }}" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                        Back 
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
