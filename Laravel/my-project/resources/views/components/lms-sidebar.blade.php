<aside class="hidden md:block w-64 bg-white border-r p-5">
    <h2 class="text-lg font-semibold text-indigo-600 mb-4">Menu</h2>
    <ul class="space-y-3">
        <li><a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-indigo-50">🏠 Dashboard</a></li>
        <li><a href="{{ route('classes.index') }}" class="block p-2 rounded hover:bg-indigo-50">📚 My Classes</a></li>
        <li><a href="{{ route('homework.index') }}" class="block p-2 rounded hover:bg-indigo-50">✏️ Homework</a></li>
        <li><a href="{{ route('grades.index') }}" class="block p-2 rounded hover:bg-indigo-50">📊 Grades</a></li>
        <li><a href="{{ route('messages.index') }}" class="block p-2 rounded hover:bg-indigo-50">💌 Messages</a></li>
        <li><a href="{{ route('settings') }}" class="block p-2 rounded hover:bg-indigo-50">⚙️ Settings</a></li>
    </ul>
</aside>
