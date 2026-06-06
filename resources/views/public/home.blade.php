@extends('layouts.public')

@section('content')

    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-emerald-900 text-white py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6">
                <span class="bg-amber-500 text-blue-950 font-bold px-3 py-1 rounded-full text-xs tracking-wider uppercase inline-block">Established 1998</span>
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    Shaping Bright Futures in <br><span class="text-amber-400">Village Kuro</span>
                </h1>
                <p class="text-lg text-blue-100 max-w-xl font-light leading-relaxed">
                    Welcome to Islamia Public School Kuro. For over two decades, we have committed to bringing high-standard primary and middle school education to District Ghanche, combining efficient teaching faculty with modern learning environments.
                </p>
                <div class="pt-4 flex flex-wrap gap-4">
                    <a href="#contact" class="bg-amber-500 hover:bg-amber-600 text-blue-950 font-bold px-6 py-3.5 rounded-lg transition shadow-md text-sm">Admissions Inquiry</a>
                    <a href="#facilities" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-medium px-6 py-3.5 rounded-lg transition text-sm">Explore Our Campus</a>
                </div>
            </div>

            <div class="lg:col-span-5 bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 shadow-xl max-h-[420px] flex flex-col">
                <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4 flex-shrink-0">
                    <h3 class="font-bold text-amber-400 flex items-center gap-2 text-base">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse block"></span> Live Notice Board
                    </h3>
                    <span class="text-xs text-blue-200">Kuro, Ghanche</span>
                </div>
                
                <div class="space-y-4 overflow-y-auto pr-1 flex-grow scrollbar-thin scrollbar-thumb-white/10">
                    @forelse($notices as $notice)
                        <div class="p-4 bg-white/5 rounded-xl border-l-4 border-amber-500 hover:bg-white/10 transition">
                            <h4 class="font-bold text-white text-sm tracking-tight">{{ $notice->title }}</h4>
                            <p class="text-xs text-blue-200 mt-1 leading-relaxed whitespace-pre-line">{{ $notice->content }}</p>
                            <span class="text-[10px] text-emerald-300 block mt-2 font-mono tracking-wider uppercase">
                                {{ $notice->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    @empty
                        <div class="p-6 text-center bg-white/5 rounded-xl border border-dashed border-white/10">
                            <p class="text-xs text-blue-200">No active circulars or notices posted at this moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div id="about" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-extrabold text-blue-900 tracking-tight">Our Academic Legacy Since 1998</h2>
                <p class="text-slate-600 leading-relaxed">
                    Islamia Public School Kuro has functioned as a cornerstone of learning in District Ghanche. We emphasize academic rigor, character building, and technological awareness to ensure children within our community are globally competitive.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="p-4 bg-white border border-slate-100 shadow-sm rounded-xl">
                        <span class="text-3xl font-black text-emerald-700 block">25+</span>
                        <span class="text-xs text-slate-500 font-medium tracking-wide uppercase mt-1 block">Years of Quality Service</span>
                    </div>
                    <div class="p-4 bg-white border border-slate-100 shadow-sm rounded-xl">
                        <span class="text-3xl font-black text-blue-900 block">100%</span>
                        <span class="text-xs text-slate-500 font-medium tracking-wide uppercase mt-1 block">Dedicated Local Faculty</span>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-emerald-800 to-blue-950 p-8 rounded-2xl text-white shadow-lg space-y-4">
                <h3 class="text-xl font-bold text-amber-400">Core Administrative Values</h3>
                <p class="text-sm text-blue-100 leading-relaxed">
                    Our school infrastructure is built to scale learning. Run by experienced, dedicated administrative personnel and high-caliber educators, we maintain an ideal student-to-teacher tracking metric to foster focus.
                </p>
            </div>
        </div>
    </div>

    <div id="facilities" class="bg-slate-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-12">
                <h2 class="text-3xl font-extrabold text-blue-900">Modern School Infrastructure</h2>
                <p class="text-slate-600 text-sm mt-3">We invest heavily in the resources necessary to support high-standard learning pipelines.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                    <div class="p-6 space-y-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-900 font-bold mb-2">
                            💻
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">Advanced Computer Lab</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Equipped with modern desktop systems enabling hands-on practice for computer science components starting from primary schooling modules.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                    <div class="p-6 space-y-3">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 font-bold mb-2">
                            ⚽
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">Central Village Playground</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Situated safely in the core center of the village, providing students clean, secure spaces for active athletic programs and physical wellness.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                    <div class="p-6 space-y-3">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-700 font-bold mb-2">
                            🏫
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">Efficient Classrooms</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Optimized desk spaces, natural daylight ventilation settings, and strict resource tracking to maintain high academic engagement metrics.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contact" class="py-20 max-w-3xl mx-auto px-4 sm:px-6">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl p-8 md:p-10">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-blue-900">Admissions & General Contact Desk</h3>
                <p class="text-sm text-slate-500 mt-2">Submit your message below. The school administration registers these queries inside our local management tracking systems.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 rounded-r-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Your Full Name</label>
                        <input type="text" name="sender_name" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="sender_email" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subject Context</label>
                    <input type="text" name="subject" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Your Detailed Message</label>
                    <textarea name="message" rows="5" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-950 text-white font-bold py-3.5 rounded-lg tracking-wider uppercase text-xs transition shadow-md">
                    Send Secure Message
                </button>
            </form>
        </div>
    </div>

@endsection