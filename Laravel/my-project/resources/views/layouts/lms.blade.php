<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Preschool LMS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-indigo-500 p-4 text-white shadow">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <h1 class="text-xl font-bold">Preschool LMS</h1>
            <ul class="flex space-x-6">
                <li><a href="{{ route('lms.index') }}" class="hover:underline">Dashboard</a></li>
                <li><a href="{{ route('lms.classes') }}" class="hover:underline">Classes</a></li>
                <li><a href="{{ route('lms.homework') }}" class="hover:underline">Homework</a></li>
                <li><a href="{{ route('lms.messages') }}" class="hover:underline">Messages</a></li>
                <li><span class="hover:underline">Profile</span></li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar + Main Content -->
    <div class="flex flex-1 w-full">
        <!-- Sidebar -->
        <aside class="hidden md:block w-64 bg-white border-r p-5 sticky top-0 h-screen">
            <h2 class="text-lg font-semibold text-indigo-600 mb-4">Menu</h2>
            <ul class="space-y-3">
                <li><a href="{{ route('lms.index') }}" class="block p-2 rounded hover:bg-indigo-50">🏠 Dashboard</a></li>
                <li><a href="{{ route('lms.classes') }}" class="block p-2 rounded hover:bg-indigo-50">📚 My Classes</a></li>
                <li><a href="{{ route('lms.homework') }}" class="block p-2 rounded hover:bg-indigo-50">✏️ Homework</a></li>
                <li><a href="{{ route('lms.grades') }}" class="block p-2 rounded hover:bg-indigo-50">📊 Grades</a></li>
                <li><a href="{{ route('lms.messages') }}" class="block p-2 rounded hover:bg-indigo-50">💌 Messages</a></li>
                <li><span class="block p-2 rounded text-gray-700">⚙️ Settings</span></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="max-w-7xl mx-auto">
                <!-- Page Title -->
                <h2 class="text-2xl font-bold mb-6">@yield('page-title', 'Welcome 👋')</h2>

                <!-- Stats Section (only if defined) -->
                @if(View::hasSection('stats'))
                    @yield('stats')
                @endif

                <!-- Dynamic Page Content -->
                <section class="mt-10">
                    @yield('content')
                </section>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-indigo-100 text-center py-4 text-sm text-gray-700">
        © {{ date('Y') }} Preschool LMS · Made with ❤️
    </footer>

</body>
</html>
