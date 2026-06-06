@extends('layouts.public')

@section('content')

    <div class="relative bg-gradient-to-r from-blue-950 via-blue-900 to-emerald-900 text-white py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <span class="bg-amber-500 text-blue-950 font-bold px-3 py-1 rounded-full text-xs tracking-wider uppercase inline-block">
                Our Team
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Our Distinguished <span class="text-amber-400">Faculty & Staff</span>
            </h1>
            <p class="text-lg text-blue-100 max-w-2xl mx-auto font-light leading-relaxed">
                Meet the dedicated educators, visionaries, and administrative staff driving academic excellence and character tracking at Village Kuro.
            </p>
            <div class="pt-4">
                <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
            </div>
        </div>
    </div>

    <div class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($faculties->isEmpty())
            <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200 max-w-lg mx-auto">
                <span class="text-3xl block mb-2">👨‍🏫</span>
                <h4 class="text-sm font-bold text-slate-700">No Active Faculty Profiles Available</h4>
                <p class="text-xs text-slate-500 mt-1">Faculty roster entries will appear here once registered via the administrator management desk.</p>
            </div>
        @else
            
            @foreach($faculties as $type => $members)
                <div class="mb-20 last:mb-0">
                    
                    <div class="flex items-center gap-4 mb-8">
                        <h2 class="text-xs font-bold tracking-widest uppercase text-blue-600 font-mono flex-shrink-0">
                            @switch(strtolower(trim($type)))
                                @case('administration')
                                @case('admin')
                                    🏢 Administration Domain
                                    @break
                                @case('visiting')
                                    💼 Visiting Faculty Panels
                                    @break
                                @case('support')
                                    🤝 Institutional Support Staff
                                    @break
                                @case('teaching')
                                @default
                                    🎓 Academic Teaching Staff
                            @endswitch
                        </h2>
                        <div class="h-[1px] bg-slate-200 flex-grow"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($members as $member)
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col group">
                                
                                <div class="aspect-square w-full bg-slate-100 border-b border-slate-100 flex items-center justify-center overflow-hidden relative">
                                    @if(!empty($member->image_path))
                                        <img src="{{ asset('storage/' . $member->image_path) }}" class="w-full h-full object-cover transition group-hover:scale-105 duration-200" alt="{{ $member->name }}">
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-950 flex items-center justify-center">
                                            <span class="text-white font-mono font-bold text-2xl uppercase tracking-wider">
                                                {{ substr($member->name, 0, 2) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-5 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900 leading-tight line-clamp-1">
                                            {{ $member->name }}
                                        </h3>
                                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wide mt-1">
                                            {{ $member->designation }}
                                        </p>
                                    </div>
                                    
                                    <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 space-y-1.5">
                                        <div class="flex items-start gap-1.5">
                                            <span class="flex-shrink-0 text-slate-400">📜</span>
                                            <span class="italic leading-normal line-clamp-2">🎓 {{ $member->qualification }}</span>
                                        </div>
                                        @if($member->department)
                                            <div class="flex items-center gap-1.5">
                                                <span class="flex-shrink-0 text-slate-400">📍</span>
                                                <span class="font-medium">{{ $member->department }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach

        @endif

    </div>

@endsection