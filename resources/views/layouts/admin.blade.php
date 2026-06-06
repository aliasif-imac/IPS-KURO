<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPS Control Panel | Administrative Framework</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col">

    <header class="bg-slate-950 border-b border-slate-800 shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-amber-500 text-slate-950 font-black px-2.5 py-1 rounded-md text-sm tracking-wider">
                    CPANEL
                </div>
                <span class="font-bold text-slate-200 tracking-tight text-sm hidden sm:block">
                    Islamia Public School Kuro — Management Terminal
                </span>
            </div>
            
            <nav class="flex items-center gap-4 text-xs font-semibold tracking-wide uppercase">
                <a href="{{ route('home') }}" target="_blank" class="text-slate-400 hover:text-white transition">View Public Site ↗</a>
                <div class="h-4 w-px bg-slate-800"></div>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="text-red-400 hover:text-red-300 transition">Secure Exit</button>
                </form>
            </nav>
        </div>
    </header>

    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10 flex-grow grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <aside class="lg:col-span-3 space-y-2">
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 px-3 mb-2">Resource Desks</div>
            
            {{-- ADDED: MAIN DASHBOARD LINK --}}
            <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    📊 Dashboard Terminal
            </a>

            <a href="{{ route('notices.index') }}" 
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('notices.index') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    📢 Circulars & Notices
            </a>

            <a href="{{ route('admin.faculty.index') }}" 
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('admin.faculty.index') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    👨‍🏫 Faculty Profiles
            </a>

            <a href="{{ route('admin.alumni.index') }}" 
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('admin.alumni.index') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    🎓 Alumni Moderation Queue
            </a>

            <a href="{{ route('admin.inquiries.index') }}" 
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('admin.inquiries.index') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    📩 Inquiry Mailbox
            </a>
        </aside>

        <main class="lg:col-span-9 space-y-6">
            @yield('admin_content')
        </main>
    </div>

</body>
</html>