<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">User Management</h1>

        <!-- Table visible on large screens -->
        <div class="hidden lg:block">
            <table class="table-auto w-full border-t border-b border-gray-300 shadow-sm">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-6 py-3 border-b border-gray-300">#</th>
                        <th class="px-6 py-3 border-b border-gray-300">Name</th>
                        <th class="px-6 py-3 border-b border-gray-300">Email</th>
                        <th class="px-6 py-3 border-b border-gray-300">Username</th>
                        <th class="px-6 py-3 border-b border-gray-300">Roles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-3 border-b border-gray-300">{{ $loop->iteration }}</td>
                            <td class="px4 py-2 border-b border-gray-300">{{ $user->name }}</td>
                            <td class="px-6 py-3 border-b border-gray-300">{{ $user->email }}</td>
                            <td class="px-6 py-3 border-b border-gray-300">{{ $user->username }}</td>
                            <td class="px-6 py-3 border-b border-gray-300">
                                @foreach ($user->roles as $role)
                                    <span class="inline-block bg-blue-500 text-white text-sm px-2 rounded">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Cards visible on small screens -->
        <div class="sm:hidden">
            <div class="grid gap-6">
                @foreach ($users as $user)
                    <div class="border border-gray-300 p-4 rounded-lg shadow-sm bg-white">
                        <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
                        <p class="text-gray-600">Email: {{ $user->email }}</p>
                        <p class="text-gray-600">Username: {{ $user->username }}</p>
                        <div class="mt-2">
                            @foreach ($user->roles as $role)
                                <span class="inline-block bg-blue-500 text-white text-sm px-2 py-1 rounded mb-2">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
