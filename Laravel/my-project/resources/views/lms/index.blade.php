<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preschool LMS · Student Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Or quick CDN if you don’t have Vite --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>
<body class="bg-pink-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-indigo-500 p-4 text-white shadow">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Preschool LMS</h1>
            <ul class="flex space-x-4">
                <li><a href="#" class="hover:underline">Dashboard</a></li>
                <li><a href="#" class="hover:underline">Classes</a></li>
                <li><a href="#" class="hover:underline">Homework</a></li>
                <li><a href="#" class="hover:underline">Messages</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-1 max-w-6xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">Hello, Student 👋</h2>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Classes Card -->
            <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
                <h3 class="text-lg font-semibold mb-2 text-indigo-600">My Classes</h3>
                <p class="text-gray-600">You are enrolled in 3 fun preschool classes.</p>
                <a href="#" class="mt-3 inline-block text-pink-500 font-medium hover:underline">
                    View Classes →
                </a>
            </div>

            <!-- Homework Card -->
            <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
                <h3 class="text-lg font-semibold mb-2 text-indigo-600">Homework</h3>
                <p class="text-gray-600">You have 2 assignments due this week.</p>
                <a href="#" class="mt-3 inline-block text-pink-500 font-medium hover:underline">
                    Check Homework →
                </a>
            </div>

            <!-- Messages Card -->
            <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
                <h3 class="text-lg font-semibold mb-2 text-indigo-600">Messages</h3>
                <p class="text-gray-600">You have 1 new message from your teacher.</p>
                <a href="#" class="mt-3 inline-block text-pink-500 font-medium hover:underline">
                    View Messages →
                </a>
            </div>
        </div>

        <!-- Classes List -->
        <section class="mt-10">
            <h2 class="text-xl font-bold mb-4">📚 My Classes</h2>
            <ul class="space-y-3">
                <li class="bg-white p-4 rounded-xl shadow">Math with Shapes & Colors</li>
                <li class="bg-white p-4 rounded-xl shadow">Storytelling & Reading</li>
                <li class="bg-white p-4 rounded-xl shadow">Arts & Crafts</li>
            </ul>
        </section>

        <!-- Homework List -->
        <section class="mt-10">
            <h2 class="text-xl font-bold mb-4">✏️ Homework</h2>
            <ul class="space-y-3">
                <li class="bg-white p-4 rounded-xl shadow">
                    Math Shapes Worksheet – <span class="text-red-500">Due Friday</span>
                </li>
                <li class="bg-white p-4 rounded-xl shadow">
                    Draw Your Family – <span class="text-red-500">Due Monday</span>
                </li>
            </ul>
        </section>

        <!-- Messages -->
        <section class="mt-10">
            <h2 class="text-xl font-bold mb-4">💌 Messages</h2>
            <div class="bg-white p-4 rounded-xl shadow mb-3">
                <p class="font-semibold">From: Teacher Anna</p>
                <p class="text-gray-600 mt-2">Don’t forget to bring your crayons tomorrow!</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-indigo-100 text-center py-4 text-sm text-gray-700">
        © {{ date('Y') }} Preschool LMS · Made with ❤️
    </footer>

</body>
</html>
