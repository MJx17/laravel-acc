<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enrollment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 mt-8">
        <h1 class="text-3xl font-semibold mb-6 text-center">Student Profile</h1>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-primary text-white px-6 py-4">
                <h3 class="text-2xl font-bold">{{ $student->first_name }} {{ $student->surname }}'s Profile</h3>
            </div>
            <div class="p-6">
                <form>
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4">Personal Information</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block font-medium text-gray-600">Name:</label>
                                <p id="name" class="text-gray-700">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->surname }}</p>
                            </div>
                            <div>
                                <label for="sex" class="block font-medium text-gray-600">Sex:</label>
                                <p id="sex" class="text-gray-700">{{ $student->sex }}</p>
                            </div>
                            <div>
                                <label for="dob" class="block font-medium text-gray-600">Date of Birth:</label>
                                <p id="dob" class="text-gray-700">{{ \Carbon\Carbon::parse($student->dob)->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <label for="age" class="block font-medium text-gray-600">Age:</label>
                                <p id="age" class="text-gray-700">{{ $student->age }}</p>
                            </div>
                            <div>
                                <label for="place_of_birth" class="block font-medium text-gray-600">Place of Birth:</label>
                                <p id="place_of_birth" class="text-gray-700">{{ $student->place_of_birth }}</p>
                            </div>
                            <div>
                                <label for="home_address" class="block font-medium text-gray-600">Address:</label>
                                <p id="home_address" class="text-gray-700">{{ $student->home_address }}</p>
                            </div>
                            <div>
                                <label for="email" class="block font-medium text-gray-600">Email:</label>
                                <p id="email" class="text-gray-700">{{ $student->email_address }}</p>
                            </div>
                            <div>
                                <label for="mobile_number" class="block font-medium text-gray-600">Mobile Number:</label>
                                <p id="mobile_number" class="text-gray-700">{{ $student->mobile_number }}</p>
                            </div>
                            <div>
                                <label for="course" class="block font-medium text-gray-600">Course:</label>
                                <p id="course" class="text-gray-700">{{ $student->course->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Parents' Information -->
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4">Parents' Information</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="fathers_name" class="block font-medium text-gray-600">Father's Name:</label>
                                <p id="fathers_name" class="text-gray-700">{{ $student->fathers_name }}</p>
                            </div>
                            <div>
                                <label for="fathers_educational_attainment" class="block font-medium text-gray-600">Father's Educational Attainment:</label>
                                <p id="fathers_educational_attainment" class="text-gray-700">{{ $student->fathers_educational_attainment }}</p>
                            </div>
                            <div>
                                <label for="fathers_address" class="block font-medium text-gray-600">Father's Address:</label>
                                <p id="fathers_address" class="text-gray-700">{{ $student->fathers_address }}</p>
                            </div>
                            <div>
                                <label for="fathers_contact_number" class="block font-medium text-gray-600">Father's Contact Number:</label>
                                <p id="fathers_contact_number" class="text-gray-700">{{ $student->fathers_contact_number }}</p>
                            </div>
                            <div>
                                <label for="fathers_occupation" class="block font-medium text-gray-600">Father's Occupation:</label>
                                <p id="fathers_occupation" class="text-gray-700">{{ $student->fathers_occupation }}</p>
                            </div>
                            <div>
                                <label for="fathers_employer" class="block font-medium text-gray-600">Father's Employer:</label>
                                <p id="fathers_employer" class="text-gray-700">{{ $student->fathers_employer }}</p>
                            </div>
                            <div>
                                <label for="fathers_employer_address" class="block font-medium text-gray-600">Father's Employer Address:</label>
                                <p id="fathers_employer_address" class="text-gray-700">{{ $student->fathers_employer_address }}</p>
                            </div>

                            <div>
                                <label for="mothers_name" class="block font-medium text-gray-600">Mother's Name:</label>
                                <p id="mothers_name" class="text-gray-700">{{ $student->mothers_name }}</p>
                            </div>
                            <div>
                                <label for="mothers_educational_attainment" class="block font-medium text-gray-600">Mother's Educational Attainment:</label>
                                <p id="mothers_educational_attainment" class="text-gray-700">{{ $student->mothers_educational_attainment }}</p>
                            </div>
                            <div>
                                <label for="mothers_address" class="block font-medium text-gray-600">Mother's Address:</label>
                                <p id="mothers_address" class="text-gray-700">{{ $student->mothers_address }}</p>
                            </div>
                            <div>
                                <label for="mothers_contact_number" class="block font-medium text-gray-600">Mother's Contact Number:</label>
                                <p id="mothers_contact_number" class="text-gray-700">{{ $student->mothers_contact_number }}</p>
                            </div>
                            <div>
                                <label for="mothers_occupation" class="block font-medium text-gray-600">Mother's Occupation:</label>
                                <p id="mothers_occupation" class="text-gray-700">{{ $student->mothers_occupation }}</p>
                            </div>
                            <div>
                                <label for="mothers_employer" class="block font-medium text-gray-600">Mother's Employer:</label>
                                <p id="mothers_employer" class="text-gray-700">{{ $student->mothers_employer }}</p>
                            </div>
                            <div>
                                <label for="mothers_employer_address" class="block font-medium text-gray-600">Mother's Employer Address:</label>
                                <p id="mothers_employer_address" class="text-gray-700">{{ $student->mothers_employer_address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Living Situation -->
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4">Living Situation</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="living_situation" class="block font-medium text-gray-600">Living Situation:</label>
                                <p id="living_situation" class="text-gray-700">{{ $student->living_situation }}</p>
                            </div>
                            <div>
                                <label for="living_address" class="block font-medium text-gray-600">Living Address:</label>
                                <p id="living_address" class="text-gray-700">{{ $student->living_address }}</p>
                            </div>
                            <div>
                                <label for="living_contact_number" class="block font-medium text-gray-600">Living Contact Number:</label>
                                <p id="living_contact_number" class="text-gray-700">{{ $student->living_contact_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Year Level -->
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4">Year Level</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="year_level" class="block font-medium text-gray-600">Year Level:</label>
                                <p id="year_level" class="text-gray-700">{{ ucfirst(str_replace('_', ' ', $student->year_level)) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4">Profile Image</h4>
                        <div class="flex justify-center">
                            @if($student->image)
                                <img src="{{ asset('storage/'.$student->image) }}" alt="Student Image" class="w-48 h-48 object-cover rounded-full">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}" class="px-6 py-3 bg-secondary text-white rounded-lg shadow-md">Go Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
