<!-- Financial Information -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Financial Information -->
    <div>
        <h3 class="text-lg font-semibold text-blue-800 dark:text-white mb-5">Financial Information</h3>

        <!-- Financier Select -->
        <div class="mb-4">
            <select name="financier" id="financier" class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm">
                <option value="" disabled
                    {{ old('financier', $financialData->financier ?? '') == '' ? 'selected' : '' }}>
                    Select Financier
                </option>
                <option value="Parents"
                    {{ old('financier', $financialData->financier ?? '') == 'Parents' ? 'selected' : '' }}>Parents
                </option>
                <option value="Relatives"
                    {{ old('financier', $financialData->financier ?? '') == 'Relatives' ? 'selected' : '' }}>Relatives
                </option>
                <option value="Guardian"
                    {{ old('financier', $financialData->financier ?? '') == 'Guardian' ? 'selected' : '' }}>Guardian
                </option>
                <option value="Myself"
                    {{ old('financier', $financialData->financier ?? '') == 'Myself' ? 'selected' : '' }}>Myself
                </option>
            </select>
            @error('financier')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Scholarship Information -->
        <div class="mb-4">
            <input type="text" name="scholarship" id="scholarship"
                class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm" placeholder="Scholarship"
                value="{{ old('scholarship', $financialData->scholarship ?? '') }}">
            @error('scholarship')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Income Information -->
        <div class="mb-4">
            <input type="text" name="income" id="income"
                class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm" placeholder="Income"
                value="{{ old('income', $financialData->income ?? '') }}">
            @error('income')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Company Name and Address -->
        <div class="mb-4">
            <input type="text" name="company_name" id="company_name"
                class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm" placeholder="Company Name"
                value="{{ old('company_name', $financialData->company_name ?? '') }}">
            @error('company_name')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <input type="text" name="company_address" id="company_address"
                class="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm" placeholder="Company Address"
                value="{{ old('company_address', $financialData->company_address ?? '') }}">
            @error('company_address')
            <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Relative Information -->
    <div id="relative-info-container">
        <div id="relative-entries">
            @foreach($enrollment->financialinformation->relative_names ?? [] as $index => $relativeName)
            <div class="relative-entry">
                <!-- Relative Name -->
                <input type="text" name="relative_names[{{ $index }}]"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    value="{{ old('relative_names.' . $index, $relativeName) }}" placeholder="Relative Name">
            </div>


            <div class="relative-entry flex flex-col border-b hover:bg-gray-300 bg-gray-200">
                <!-- Accordion Button -->
                <div class="relative-entry-header px-4 py-3 flex justify-between items-center cursor-pointer">
                    <span class="text-lg font-medium text-gray-700">Relative {{ $index + 1 }}</span>
                    <svg class="w-6 h-6 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                        id="accordion-toggle-{{ $index }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>

                <!-- Accordion Content -->
                <div class="relative-entry-details px-4 py-3 hidden" id="relative-entry-details-{{ $index }}">
                    <div class="px-4 py-2">
                        <input type="text" name="relative_names[{{ $index }}]"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out"
                            placeholder="Name"
                            value="{{ old('relative_names.' . $index, $relativeNames[$index] ?? '') }}">
                    </div>
                    <div class="px-4 py-2">
                        <input type="text" name="relationships[{{ $index }}]"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out"
                            placeholder="Relationship"
                            value="{{ old('relationships.' . $index, $relationships[$index] ?? '') }}">
                    </div>
                    <div class="px-4 py-2">
                        <input type="text" name="position_courses[{{ $index }}]"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out"
                            placeholder="Position/Course"
                            value="{{ old('position_courses.' . $index, $positionCourses[$index] ?? '') }}">
                    </div>
                    <div class="px-4 py-2">
                        <input type="text" name="relative_contact_numbers[{{ $index }}]"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 ease-in-out"
                            placeholder="Contact Number"
                            value="{{ old('relative_contact_numbers.' . $index, $relativeContactNumbers[$index] ?? '') }}">
                    </div>
                </div>

                <!-- Remove Button -->
                <div class="px-4 py-2 text-center flex justify-end">
                    <button type="button"
                        class="remove-relative text-red-600 hover:text-red-800 font-semibold rounded-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.032 2.642l-.168.054a2.25 2.25 0 0 1-2.031-2.641m-9.36 0c-.342-.052-.682-.107-1.022-.166M10.16 4.68a2.25 2.25 0 0 0 0 4.481m-1.828-3.98c.163-.205.356-.387.572-.559m-7.202.02a2.25 2.25 0 0 1-.237-.346" />
                        </svg>
                        Remove
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Add New Relative -->
        <div class="flex justify-center mt-4">
            <button type="button" id="add-relative"
                class="text-blue-600 hover:text-blue-800 font-semibold rounded-md transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                </svg>
                Add New Relative
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addRelativeButton = document.getElementById('add-relative');
    const container = document.getElementById('relative-entries');

    // Function to handle adding a new relative dynamically
    function addRelative() {
        const firstEntry = document.querySelector('.relative-entry');
        if (!firstEntry) return; // Safety check
        const newEntry = firstEntry.cloneNode(true);
        const entryCount = container.querySelectorAll('.relative-entry').length;

        // Update each input in the cloned row with the new index
        newEntry.querySelectorAll('input').forEach((input) => {
            input.value = ''; // Clear the value
            const name = input.getAttribute('name');
            const updatedName = name.replace(/\[\d+\]/, `[${entryCount}]`);
            input.setAttribute('name', updatedName);
        });

        container.appendChild(newEntry);
    }

    // Toggle accordion visibility
    container.addEventListener('click', function(e) {
        if (e.target && e.target.matches('.relative-entry-header')) {
            const index = e.target.id.split('-').pop();
            const details = document.getElementById(`relative-entry-details-${index}`);
            details.classList.toggle('hidden');
            const icon = e.target.querySelector('svg');
            icon.classList.toggle('rotate-45');
        }
    });

    // Event listener for adding a new relative
    addRelativeButton.addEventListener('click', addRelative);

    // Remove relative entry
    container.addEventListener('click', function(e) {
        if (e.target && e.target.matches('.remove-relative')) {
            const relativeEntry = e.target.closest('.relative-entry');
            relativeEntry.remove();
        }
    });
});
</script>