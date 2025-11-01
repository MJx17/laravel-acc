<nav class="bg-indigo-500 p-4 text-white shadow">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">Preschool LMS</h1>
        <ul class="flex space-x-6">
            <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
            <li><a href="{{ route('classes.index') }}" class="hover:underline">Classes</a></li>
            <li><a href="{{ route('homework.index') }}" class="hover:underline">Homework</a></li>
            <li><a href="{{ route('messages.index') }}" class="hover:underline">Messages</a></li>
            <li><a href="{{ route('profile') }}" class="hover:underline">Profile</a></li>
        </ul>
    </div>
</nav>
