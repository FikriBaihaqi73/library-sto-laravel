<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Library STO') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100 hidden" id="main-nav">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="/dashboard" class="font-bold text-xl text-orange-500">
                                <i class="fa-solid fa-book-open"></i> Library STO
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="/dashboard" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                            <a href="/scan" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Scan Book
                            </a>
                             <a href="/admin/dashboard" id="nav-admin-link" class="hidden inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Admin Dashboard
                            </a>
                        </div>
                    </div>
                     <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <button id="logout-btn" class="text-gray-500 hover:text-gray-700">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <footer class="bg-white border-t border-gray-100 mt-auto py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Library STO. All rights reserved.
            </div>
        </footer>
    </div>
    
    <script>
        // Check auth on load
        document.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('token');
            const nav = document.getElementById('main-nav');
            const adminLink = document.getElementById('nav-admin-link');
            
            // Simple check to show/hide nav. Ideally middleware handles redirect.
            if (token && nav) {
               nav.classList.remove('hidden');
               // Highlight active link
               const path = window.location.pathname;
               const links = nav.querySelectorAll('a');
               links.forEach(link => {
                   if (link.getAttribute('href') === path) {
                       link.classList.add('border-orange-500', 'text-gray-900');
                       link.classList.remove('border-transparent', 'text-gray-500');
                   }
               });
               
               // Initial Role Check (Fast)
               checkRole();

               // Force Refresh User Data (Reliable)
               fetch('/api/auth/me', {
                   headers: { 'Authorization': 'Bearer ' + token }
               })
               .then(res => {
                   if(res.ok) return res.json();
                   throw new Error('Failed to fetch user');
               })
               .then(userData => {
                   localStorage.setItem('user', JSON.stringify(userData));
                   checkRole(); // Re-check with fresh data
               })
               .catch(err => {
                   console.error(err);
                   // If token invalid, logout
                   // localStorage.removeItem('token');
                   // localStorage.removeItem('user');
                   // window.location.href = '/login';
               });
            }

            function checkRole() {
                const userStr = localStorage.getItem('user');
                const adminLink = document.getElementById('nav-admin-link');
                
                if (userStr && adminLink) {
                    const user = JSON.parse(userStr);
                    if (user && user.role === 'admin') {
                        adminLink.style.display = 'inline-flex';
                        adminLink.classList.remove('hidden');
                    } else {
                        adminLink.style.display = 'none';
                    }
                } else if (adminLink) {
                    adminLink.style.display = 'none';
                }
            }

            const logoutBtn = document.getElementById('logout-btn');
            if(logoutBtn) {
                logoutBtn.addEventListener('click', async () => {
                    try {
                        await fetch('/api/auth/logout', {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Content-Type': 'application/json'
                            }
                        });
                    } catch (e) {
                        console.error(e);
                    }
                    localStorage.removeItem('token');
                    localStorage.removeItem('user'); // Clear user data
                    window.location.href = '/login';
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
