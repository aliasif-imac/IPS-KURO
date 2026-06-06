<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Islamia Public School Kuro | Ghanche, Gilgit-Baltistan</title>
    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Global Top Navigation Bar -->
    <header class="bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-700 flex items-center justify-center text-white font-extrabold shadow-sm">
                    IPS
                </div>
                <div>
                    <span class="font-extrabold text-blue-900 tracking-tight text-lg block">ISLAMIA PUBLIC SCHOOL</span>
                    <span class="text-xs font-semibold text-emerald-700 tracking-wider block -mt-1">KURO • ESTD 1998</span>
                </div>
            </div>
            
            <!-- Public Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('home') }}" class="hover:text-blue-900 transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-blue-900 transition">About Us</a>
                <a href="{{ route('public.faculty') }}" class="text-sm font-medium text-slate-700 hover:text-blue-900 transition"> Faculty </a>
                <a href="#facilities" class="hover:text-blue-900 transition">Facilities</a>
                <a href="{{ route('alumni.index') }}" class="hover:text-blue-900 transition">Alumni Hub</a>
                <a href="#contact" class="bg-blue-900 hover:bg-blue-950 text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition shadow-sm">Contact Us</a>
            
            </nav>
        </div>
    </header>

    <!-- Main Dynamic Content Wrapper Viewport -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Layout Institutional Footer Section -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="text-white font-bold text-base mb-4">Islamia Public School Kuro</h4>
                <p class="text-sm leading-relaxed max-w-sm">
                    Providing high-standard primary and middle school education in District Ghanche, Gilgit-Baltistan since 1998.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold text-base mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('alumni.index') }}" class="hover:text-white transition">Alumni Registration</a></li>
                    <li><a href="{{ route('login') }}" class="text-xs text-slate-400 hover:text-amber-400 transition">🔒 Admin Portal </a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold text-base mb-4">Campus Location</h4>
                <p class="text-sm leading-relaxed">
                    Main Bazaar Road, Village Kuro,<br>
                    District Ghanche, Gilgit-Baltistan,<br>
                    Pakistan.
                </p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-slate-800 text-center text-xs">
            &copy; {{ date('Y') }} Islamia Public School Kuro. All Rights Reserved.
        </div>
    </footer>

</body>
</html>