<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body class="h-full font-sans">

    <div class="flex h-full">
        {{-- Sidebar partial --}}
        @include('partials.sidebar')

        {{-- Overlay untuk mobile sidebar --}}
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 md:hidden"></div>

        {{-- Konten utama --}}
        <main class="ml-64 flex-1 p-8">
            @yield('content')
        </main>
    </div>

    <style>
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            transition: all 150ms ease-in-out;
            cursor: pointer;
            text-decoration: none;
        }
    </style>

    {{-- Global script for mobile sidebar toggle (available to all pages) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            // delegate clicks for menu button(s)
            document.addEventListener('click', function (e) {
                // open sidebar
                if (e.target.closest('#menu-btn')) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                }
                // close when clicking overlay or close-btn (if you add one)
                if (e.target.closest('#overlay') || e.target.closest('.sidebar-close')) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            });

            // close sidebar when window resized to md+ (so state consistent)
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    // ensure sidebar is visible on md and larger
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                } else {
                    // hide sidebar by default on small screens
                    if (!sidebar.classList.contains('-translate-x-full')) {
                        // keep it visible only if user opened it
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>