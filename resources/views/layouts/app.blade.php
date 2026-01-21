<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tible - Time & Attendance')</title>

    <!-- Google Fonts: Roboto & Open Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Roboto:wght@400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Open Sans', 'sans-serif'],
                        display: ['Roboto', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            black: '#1a1a1a',      // Woodsmoke
                            orange: '#f7931e',     // Brand Signal
                            gray: '#8c8c8c',       // Brand Gray
                            white: '#fcfcfc',      // Brand White
                        },
                        primary: {
                            50: '#fcfcfc',
                            100: '#f5f5f5',
                            200: '#e5e5e5',
                            300: '#d4d4d4',
                            400: '#a3a3a3',
                            500: '#f7931e',
                            600: '#1a1a1a',
                            700: '#f7931e',
                            800: '#c2410c',
                            900: '#7c2d12',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.6s ease-out forwards',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8fafc;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Roboto', sans-serif;
        }

        .btn-brand {
            background-color: #1a1a1a;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-brand:hover {
            background-color: #f7931e;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(247, 147, 30, 0.3);
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #f7931e;
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>

<body class="min-h-screen text-brand-black">
    <!-- Navigation Bar -->
    @if(session('user'))
        <nav class="bg-white shadow-md border-b border-brand-gray/10 sticky top-0 z-50 animate-fade-in">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <img src="{{ asset('images/logo.webp') }}" alt="Tible Logo"
                                class="h-10 w-auto hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                            <a href="/dashboard"
                                class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-brand-black">
                                Dashboard
                            </a>
                            <a href="#"
                                class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-brand-gray hover:text-brand-black transition">
                                Schedule
                            </a>
                            <a href="#"
                                class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium text-brand-gray hover:text-brand-black transition">
                                Reports
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center space-x-6">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-brand-black">{{ session('user')['name'] ?? 'User' }}</p>
                                <p class="text-xs text-brand-orange uppercase tracking-wide font-semibold">
                                    {{ session('user')['role'] ?? 'employee' }}
                                </p>
                            </div>
                            <div
                                class="h-8 w-8 rounded-full bg-brand-black text-white flex items-center justify-center font-bold text-sm shadow-md">
                                {{ substr(session('user')['name'] ?? 'U', 0, 1) }}
                            </div>
                            <form action="/logout" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-brand-gray hover:text-brand-orange transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Tible T&A - Time & Attendance Tracker
            </p>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>