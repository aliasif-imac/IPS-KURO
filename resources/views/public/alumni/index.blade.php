@extends('layouts.public')

@section('content')

    <div class="bg-gradient-to-r from-emerald-900 to-blue-950 text-white py-16 px-4 text-center">
        <div class="max-w-4xl mx-auto space-y-4">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Alumni Network & Wall of Fame</h1>
            <p class="text-emerald-100 font-light text-sm sm:text-base max-w-2xl mx-auto">
                Celebrating our student legacy from Village Kuro to the global landscape. Our old students are serving honorably across Pakistan and internationally.
            </p>
            <div class="pt-2">
                <a href="{{ route('alumni.register') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-blue-950 font-bold px-5 py-2.5 rounded-lg text-xs tracking-wider uppercase shadow-md transition">
                    Register as an Alumnus
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        @if(session('success'))
            <div class="mb-10 p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 rounded-r-xl text-sm font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- DIRECTORY CONTROL FILTER BAR DESK MODULE -->
        <form method="GET" action="{{ route('alumni.index') }}" class="bg-slate-50 border border-slate-200/80 p-5 rounded-2xl mb-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end shadow-sm">
            <!-- Text Search Filter -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 pl-0.5">Search Profile</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, profession, city..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-emerald-600 transition">
            </div>

            <!-- Graduation Year Range Selection Dropdown -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 pl-0.5">Graduation Year</label>
                <select name="year" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 focus:outline-none focus:border-emerald-600 transition">
                    <option value="">All Graduation Years</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>Class of {{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Index Re-ordering Rules Matrix Selection -->
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 pl-0.5">Sort Directory</label>
                <select name="sort" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 focus:outline-none focus:border-emerald-600 transition">
                    <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Class Year (Newest First)</option>
                    <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Class Year (Oldest First)</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Alumni Name (A to Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Alumni Name (Z to A)</option>
                </select>
            </div>

            <!-- Execution Action Call Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-grow bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl transition uppercase tracking-wider shadow-sm">
                    Filter Records
                </button>
                @if(request()->anyFilled(['search', 'year', 'sort']))
                    <a href="{{ route('alumni.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-xs py-2.5 px-3 rounded-xl transition text-center flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- ALUMNI RECORDS PORTAL SECTION DISPLAY GRID -->
        @if($alumni->isEmpty())
            <div class="text-center py-16 border border-dashed border-slate-200 rounded-2xl bg-white max-w-md mx-auto">
                <span class="text-4xl">🔍</span>
                <h3 class="font-bold text-slate-700 text-lg mt-3">No Profiles Found</h3>
                <p class="text-slate-500 text-xs mt-1 px-6 leading-relaxed">No registered profiles matched your current filtering criteria. Try adjusting your parameters or clearing the search bar.</p>
                <a href="{{ route('alumni.index') }}" class="text-xs font-bold text-emerald-700 hover:underline mt-4 inline-block">&larr; View All Profiles</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($alumni as $alumnus)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden hover:shadow-md transition duration-300 flex flex-col">
                        
                        <div class="bg-slate-50 h-48 w-full flex items-center justify-center relative border-b border-slate-100 overflow-hidden">
                            @if($alumnus->profile_image_path)
                                <img src="{{ asset('storage/' . $alumnus->profile_image_path) }}" alt="{{ $alumnus->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-900 flex items-center justify-center font-bold text-xl uppercase tracking-wider">
                                    {{ substr($alumnus->name, 0, 2) }}
                                </div>
                            @endif
                            <span class="absolute bottom-3 right-3 bg-blue-900 text-white text-[10px] px-2.5 py-0.5 rounded-full font-bold tracking-wide uppercase shadow-sm">
                                Class of {{ $alumnus->graduation_year }}
                            </span>
                        </div>

                        <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                            <div>
                                <h4 class="font-bold text-slate-800 text-lg leading-snug">{{ $alumnus->name }}</h4>
                                <p class="text-xs text-emerald-700 font-semibold tracking-wide uppercase mt-0.5">{{ $alumnus->current_profession }}</p>
                                
                                @if($alumnus->current_organization)
                                    <p class="text-xs text-slate-500 mt-0.5 font-medium">{{ $alumnus->current_organization }}</p>
                                @endif
                                
                                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1 font-medium">
                                    📍 {{ $alumnus->city }}, {{ $alumnus->country }}
                                </p>
                            </div>

                            @if($alumnus->testimonial)
                                <div class="border-t border-slate-100 pt-3 italic text-xs text-slate-600 leading-relaxed">
                                    "{!! Str::limit(e($alumnus->testimonial), 140) !!}"
                               </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- SERVER PAGINATION ENGINE NAVIGATION RENDERING MAP -->
            <div class="mt-12 bg-white px-4 py-3 border border-slate-200/60 rounded-2xl shadow-sm">
                {{ $alumni->links() }}
            </div>
        @endif
    </div>

@endsection