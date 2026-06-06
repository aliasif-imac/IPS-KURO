@extends('layouts.public')

@section('content')

    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-emerald-900 text-white py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span class="bg-amber-500 text-blue-950 font-bold px-3 py-1 rounded-full text-xs tracking-wider uppercase inline-block">
                Our History
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                About <span class="text-amber-400">Our Institution</span>
            </h1>
            <p class="text-lg text-blue-100 max-w-2xl mx-auto font-light leading-relaxed">
                Discover the legacy, foundational principles, and academic driving engines behind Islamia Public School Kuro in Village Kuro.
            </p>
            <div class="pt-4">
                <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
            </div>
        </div>
    </div>

    <div id="heritage" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-extrabold text-blue-900 tracking-tight">Our Academic Legacy Since 1998</h2>
                <p class="text-slate-600 leading-relaxed">
                    Islamia Public School Kuro has functioned as a cornerstone of learning in District Ghanche. We emphasize academic rigor, character building, and technological awareness to ensure children within our community are globally competitive.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Through modern infrastructure investments, a structured standard curriculum context, and specialized teacher development plans, we empower students to confidently cross milestone educational thresholds.
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
                <h3 class="text-xl font-bold text-amber-400">Vision & Mission Focus</h3>
                <p class="text-sm text-blue-100 leading-relaxed">
                    To deliver premier, accessible education that merges core moral values with contemporary logic pipelines. We maintain an ideal student-to-teacher tracking metric to ensure that individual capabilities are thoroughly observed, nurtured, and accelerated.
                </p>
            </div>
        </div>
    </div>

    <div id="principal-desk" class="py-20 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-16">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest bg-blue-50 px-3 py-1 rounded-full">
                    Institutional Leadership
                </span>
                <h2 class="text-3xl font-extrabold text-blue-900 mt-3">Message From The Principal's Desk</h2>
                <p class="text-slate-600 text-sm mt-2">Guiding academic strategies and administrative vision at Village Kuro.</p>
            </div>

            <div class="max-w-4xl mx-auto bg-white border border-slate-200/80 rounded-2xl p-8 md:p-10 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
                    
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-slate-50 border-2 border-slate-100 flex-shrink-0 flex items-center justify-center shadow-inner">
                        @if(isset($principal) && !empty($principal->image_path))
                            <img src="{{ asset('storage/' . $principal->image_path) }}" class="w-full h-full object-cover" alt="Principal">
                        @else
                            <span class="text-slate-400 font-extrabold text-2xl uppercase tracking-wider bg-slate-100 w-full h-full flex items-center justify-center">
                                {{ isset($principal) ? substr($principal->name, 0, 2) : 'IPS' }}
                            </span>
                        @endif
                    </div>

                    <div class="flex-grow text-center md:text-left space-y-4">
                        <span class="text-4xl text-blue-900 font-serif select-none block leading-none h-3 text-left opacity-20">“</span>
                        <p class="text-slate-600 text-sm leading-relaxed italic">
                            "Welcome to our learning ecosystem. Education here extends beyond textbook parameters; it is an ongoing journey of character composition and critical intellect exploration. We look forward to partnering with parents to guide our next generation of innovators and community builders."
                        </p>
                        
                        <div class="pt-4 border-t border-slate-100">
                            <h3 class="font-bold text-slate-900 text-base">
                                {{ isset($principal) ? $principal->name : 'Honorable Principal' }}
                            </h3>
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mt-0.5">
                                {{ isset($principal) ? $principal->designation : 'Head of Institution' }}
                            </p>
                            @if(isset($principal))
                                <p class="text-[11px] text-slate-500 font-medium italic mt-2">
                                    🎓 {{ $principal->qualification }}
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection