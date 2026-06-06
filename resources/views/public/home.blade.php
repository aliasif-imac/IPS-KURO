@extends('layouts.public')

@section('content')

    <div class="relative py-32 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/school-building.jpg') }}" alt="Islamia Public School Kuro" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/95 via-blue-900/90 to-emerald-900/80"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="max-w-3xl">
                <span class="inline-block bg-amber-500 text-blue-950 font-bold px-4 py-1 rounded-full text-xs tracking-wider uppercase mb-6 shadow-sm">Established 1998</span>
                <h1 class="text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                    Cultivating Excellence in <br><span class="text-amber-400">Village Kuro</span>
                </h1>
                <p class="text-xl text-blue-100 font-light leading-relaxed mb-8 max-w-2xl">
                    For over two decades, we have committed to bringing high-standard primary and middle school education to District Ghanche, combining efficient teaching faculty with modern learning environments.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#contact" class="bg-amber-500 hover:bg-amber-600 text-blue-950 font-bold px-8 py-4 rounded-xl transition shadow-lg text-sm">Admissions Inquiry</a>
                    <a href="#facilities" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold px-8 py-4 rounded-xl transition text-sm">Explore Our Campus</a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white py-10 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl font-black text-blue-900">25+</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Years of Legacy</div>
            </div>
            <div>
                <div class="text-3xl font-black text-emerald-700">100%</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Local Faculty</div>
            </div>
            <div>
                <div class="text-3xl font-black text-amber-500">Ghanche</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">District Focus</div>
            </div>
            <div>
                <div class="text-3xl font-black text-blue-900">1998</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Founding Year</div>
            </div>
        </div>
    </div>

    <div id="about" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-extrabold text-blue-900 tracking-tight">Our Academic Legacy</h2>
                <p class="text-slate-600 leading-relaxed">
                    Islamia Public School Kuro has functioned as a cornerstone of learning in District Ghanche. We emphasize academic rigor, character building, and technological awareness to ensure children within our community are globally competitive.
                </p>
            </div>
            <div class="bg-gradient-to-br from-emerald-800 to-blue-950 p-8 rounded-2xl text-white shadow-lg">
                <h3 class="text-xl font-bold text-amber-400 mb-4">Core Administrative Values</h3>
                <p class="text-sm text-blue-100 leading-relaxed">
                    Our school infrastructure is built to scale learning. Run by experienced, dedicated administrative personnel and high-caliber educators, we maintain an ideal student-to-teacher tracking metric to foster focus and academic excellence.
                </p>
            </div>
        </div>
    </div>

    <div id="facilities" class="bg-slate-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-12">
                <h2 class="text-3xl font-extrabold text-blue-900">Modern School Infrastructure</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-900 font-bold mb-4">💻</div>
                    <h3 class="font-bold text-slate-800 mb-2">Advanced Computer Lab</h3>
                    <p class="text-sm text-slate-600">Equipped with modern desktop systems enabling hands-on practice for computer science components.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-800 font-bold mb-4">⚽</div>
                    <h3 class="font-bold text-slate-800 mb-2">Central Village Playground</h3>
                    <p class="text-sm text-slate-600">A clean, secure space in the village core for active athletic programs and physical wellness.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-700 font-bold mb-4">🏫</div>
                    <h3 class="font-bold text-slate-800 mb-2">Efficient Classrooms</h3>
                    <p class="text-sm text-slate-600">Optimized desk spaces and natural daylight settings to maintain high academic engagement.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="notices" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-blue-900">Latest Circulars & Notices</h2>
                    <p class="text-slate-500 mt-2">Stay updated with the latest institutional announcements.</p>
                </div>
                <a href="{{ route('public.notices') }}" class="text-emerald-700 font-bold text-sm hover:underline">View All &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($notices->take(6) as $notice)
                    <div class="group p-6 bg-slate-50 rounded-2xl border border-slate-100 hover:border-blue-200 transition-all hover:shadow-lg">
                        <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest">{{ $notice->created_at->format('M d, Y') }}</span>
                        <h4 class="font-bold text-slate-900 text-lg mt-2 mb-2 group-hover:text-blue-900">{{ $notice->title }}</h4>
                        <p class="text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $notice->content }}</p>
                    </div>
                @empty
                    <p class="text-slate-400">No active notices at this time.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div id="contact" class="py-20 max-w-3xl mx-auto px-4 sm:px-6">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl p-8 md:p-10">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-blue-900">Admissions & Contact Desk</h3>
            </div>
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input type="text" name="sender_name" placeholder="Your Full Name" required class="w-full px-4 py-3 rounded-lg border border-slate-200 text-sm">
                    <input type="email" name="sender_email" placeholder="Email Address" required class="w-full px-4 py-3 rounded-lg border border-slate-200 text-sm">
                </div>
                <input type="text" name="subject" placeholder="Subject" required class="w-full px-4 py-3 rounded-lg border border-slate-200 text-sm">
                <textarea name="message" rows="5" placeholder="Your Message" required class="w-full px-4 py-3 rounded-lg border border-slate-200 text-sm"></textarea>
                <button type="submit" class="w-full bg-blue-900 hover:bg-blue-950 text-white font-bold py-3.5 rounded-lg text-xs uppercase tracking-wider">Send Message</button>
            </form>
        </div>
    </div>

@endsection