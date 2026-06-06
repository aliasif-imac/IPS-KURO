@extends('layouts.admin')

@section('admin_content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-950 border border-slate-800 p-6 rounded-2xl shadow-md">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-white">Alumni Profiles Verification Gateway</h1>
            <p class="text-xs text-slate-400 mt-1">Review, authorize, or purge submissions targeting the public Wall of Fame matrix.</p>
        </div>
        <span class="bg-blue-900/40 text-blue-400 border border-blue-800 text-xs px-3 py-1 rounded-full font-mono font-bold">
            Pending Queue: {{ $pendingAlumni->count() }}
        </span>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-950 border border-emerald-800 text-emerald-400 rounded-xl text-xs font-semibold shadow-sm animate-pulse">
            ✔ {{ session('success') }}
        </div>
    @endif

    <!-- PENDING APPLICATIONS MODULE GATEWAY QUEUE -->
    <div class="space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-amber-500 pl-1 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span> Profiles Awaiting Administrative Decision
        </h3>

        @if($pendingAlumni->isEmpty())
            <div class="p-10 border border-dashed border-slate-800 rounded-2xl bg-slate-950/40 text-center text-slate-500 text-xs leading-relaxed">
                🎉 No pending applications found in the gateway. Your tracking system is fully up to date.
            </div>
        @else
            <div class="space-y-3">
                @foreach($pendingAlumni as $item)
                    <div class="bg-slate-950 border border-slate-800/80 rounded-2xl p-5 flex flex-col md:flex-row justify-between gap-6 items-start md:items-center hover:border-slate-700 transition">
                        
                        <div class="flex gap-4 items-start">
                            <div class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if($item->profile_image_path)
                                    <img src="{{ asset('storage/' . $item->profile_image_path) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                    <span class="text-slate-400 font-bold text-sm uppercase">{{ substr($item->name, 0, 2) }}</span>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="font-bold text-white text-base leading-tight">{{ $item->name }}</h4>
                                    <span class="bg-slate-800 text-slate-300 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Class of {{ $item->graduation_year }}</span>
                                </div>
                                <p class="text-xs font-semibold text-blue-400 tracking-wide uppercase">{{ $item->current_profession }} <span class="text-slate-500 font-normal lowercase">at</span> {{ $item->current_organization ?? 'N/A' }}</p>
                                <p class="text-[11px] text-slate-500">📍 {{ $item->city }}, {{ $item->country }} | ✉ {{ $item->email }}</p>
                                
                                @if($item->testimonial)
                                    <p class="text-xs text-slate-400 italic bg-slate-900/80 p-3 rounded-xl border border-slate-800 mt-2 max-w-xl leading-relaxed">"{{ $item->testimonial }}"</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex gap-2 w-full md:w-auto justify-end border-t border-slate-900 md:border-none pt-4 md:pt-0">
                            <form action="{{ route('admin.alumni.status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold px-4 py-2 rounded-lg text-xs tracking-wider uppercase transition shadow-md">
                                    Approve Profile
                                </button>
                            </form>

                            <form action="{{ route('admin.alumni.status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-slate-900 hover:bg-red-950 hover:text-red-400 text-slate-400 border border-slate-800 hover:border-red-900 font-medium px-4 py-2 rounded-lg text-xs tracking-wider uppercase transition">
                                    Reject
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- VERIFIED PLATFORM ARCHIVE & FILTER CONTROL SYSTEM -->
    <div class="space-y-4 pt-10">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pl-1">
            Verified Records Displaying Publicly
        </h3>

        <!-- Admin Filters Hub Control Bar -->
        <form method="GET" action="{{ route('admin.alumni.index') }}" class="bg-slate-950 border border-slate-800 p-4 rounded-2xl grid grid-cols-1 sm:grid-cols-3 gap-4 items-end shadow-md">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Search Directory</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, domain..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Sorting Rules Matrix</label>
                <select name="sort" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition">
                    <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Class Year (Newest First)</option>
                    <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Class Year (Oldest First)</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Alumni Name (A to Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Alumni Name (Z to A)</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-grow bg-blue-900 hover:bg-blue-800 border border-blue-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl transition uppercase tracking-wider shadow-sm">
                    Apply Filter Matrix
                </button>
                @if(request()->anyFilled(['search', 'sort']))
                    <a href="{{ route('admin.alumni.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs py-2.5 px-3 rounded-xl transition text-center flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if($approvedAlumni->isEmpty())
            <div class="p-10 border border-dashed border-slate-800 bg-slate-950/20 rounded-2xl text-center text-slate-500 text-xs leading-relaxed">
                🔍 No active profiles matched your current search parameters or directory constraints.
            </div>
        @else
            <div class="bg-slate-950 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-[10px] font-bold uppercase text-slate-500 bg-slate-950">
                            <th class="p-4">Alumnus Name</th>
                            <th class="p-4">Class Year</th>
                            <th class="p-4">Current Domain / Location</th>
                            <th class="p-4 text-right">Moderation Context</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-900 text-xs font-medium text-slate-300">
                        @foreach($approvedAlumni as $record)
                            <tr class="hover:bg-slate-900/40 transition">
                                <td class="p-4 text-white font-semibold">{{ $record->name }}</td>
                                <td class="p-4"><span class="font-mono bg-slate-900 px-2 py-1 rounded border border-slate-800">{{ $record->graduation_year }}</span></td>
                                <td class="p-4">
                                    <div class="text-blue-400 font-semibold">{{ $record->current_profession }}</div>
                                    <div class="text-[10px] text-slate-500 font-light">{{ $record->city }}, {{ $record->country }}</div>
                                </td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('admin.alumni.status', $record->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="text-red-400 hover:text-red-300 font-bold text-[11px] tracking-wide uppercase transition duration-150">
                                            Revoke View
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- SERVER PAGINATION NAVIGATION FRAMEWORK FOOTER CONTAINER -->
            <div class="mt-4 bg-slate-950 border border-slate-800 p-4 rounded-2xl shadow-md admin-dark-pagination">
                {{ $approvedAlumni->links() }}
            </div>
        @endif
    </div>

@endsection