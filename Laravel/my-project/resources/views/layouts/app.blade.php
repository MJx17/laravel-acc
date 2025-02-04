<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')

</head>
<body class="bg-gray-100">
    <div class="app">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Sidebar -->
        @include('partials.sidebar')
    </div>

    <!-- Main Content -->
    <div id="main-content" class="transition-all duration-300 p-4">
        {{ $slot }} <!-- This is where your page-specific content goes -->
        
        <!-- Insert the Livewire component for the dual listbox here -->
  
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggleButton = document.getElementById('sidebar-toggle-button');
            const sidebarCloseButton = document.getElementById('sidebar-close-button');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Toggle sidebar visibility
            sidebarToggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                mainContent.classList.toggle('ml-64'); // Add margin when sidebar is open
            });

            sidebarCloseButton.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('ml-64'); // Remove margin when sidebar is closed
            });

            // Close sidebar when clicking outside
            sidebar.addEventListener('click', (event) => {
                if (event.target === sidebar) {
                    sidebar.classList.add('-translate-x-full');
                    mainContent.classList.remove('ml-64'); // Remove margin when sidebar is closed
                }
            });
        });
    </script>


</body>
</html>
