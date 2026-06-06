@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6" x-data="{ commandPaletteOpen: false }">

    {{-- ADVANCED COMMAND PALETTE WINDOW (CTRL + K) --}}
    <div id="command-palette" 
         class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20 hidden" 
         role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCommandPalette(false)"></div>

        {{-- Panel Container --}}
        <div class="mx-auto max-w-xl transform divide-y divide-slate-100 overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all mt-12 border border-slate-200">
            <div class="relative">
                <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">🔍</span>
                <input type="text" id="palette-search" class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-slate-900 placeholder-slate-400 focus:ring-0 text-sm focus:outline-none" placeholder="Search terminal or run shortcut actions..." onkeyup="filterPalette()">
            </div>
            <ul class="max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-slate-700" id="palette-results">
                <li><a href="/admin/notices" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 transition font-medium text-slate-800"><span>📢</span> Create Circular Memo Notice</a></li>
                <li><a href="/admin/faculty" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 transition font-medium text-slate-800"><span>💼</span> Access Faculty Roster Directory</a></li>
                <li><a href="/admin/alumni" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 transition font-medium text-slate-800"><span>🎓</span> Review Pending Alumni Requests</a></li>
                <li><a href="/admin/inquiries" class="flex items-center gap-3 px-4 py-2.5 hover:bg-slate-50 transition font-medium text-slate-800"><span>✉️</span> Inspect Live Inbound Query Queue</a></li>
            </ul>
            <div class="flex items-center justify-between bg-slate-50 px-4 py-2.5 text-[11px] font-medium text-slate-400">
                <span>Tip: Type to filter shortcuts instantly</span>
                <span><kbd class="bg-white border border-slate-200 px-1.5 py-0.5 rounded text-slate-500 shadow-sm">ESC</kbd> to close</span>
            </div>
        </div>
    </div>

    {{-- DASHBOARD TOP CONTROLS FRAME --}}
    <div class="flex items-center justify-between bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-xs text-slate-500 mt-1">Live terminal analytical metrics tracking operations across all system core workspaces.</p>
        </div>
        <div class="flex items-center gap-4">
            <button onclick="toggleCommandPalette(true)" class="hidden md:flex items-center gap-2 border border-slate-200 hover:border-slate-300 bg-slate-50 hover:bg-slate-100 px-3 py-1.5 rounded-xl transition text-xs font-semibold text-slate-500 shadow-sm">
                <span>Terminal Shortcuts</span>
                <kbd class="bg-white border border-slate-200 px-1.5 py-0.5 rounded text-[10px] text-slate-400 font-mono font-bold">Ctrl + K</kbd>
            </button>
            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
            <div class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-xs font-bold text-blue-600">🛡️</div>
                <span class="text-sm font-semibold text-slate-700">Administrator</span>
            </div>
        </div>
    </div>

    {{-- ADVANCED TILES MATRIX --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $tiles = [
                ['title' => 'Total Notices', 'count' => \App\Models\Notice::count(), 'route' => '/admin/notices', 'color' => 'text-blue-600 bg-blue-50 border-blue-100'],
                ['title' => 'Active Faculty', 'count' => $facultyStats['total'], 'route' => '/admin/faculty', 'color' => 'text-purple-600 bg-purple-50 border-purple-100'],
                ['title' => 'Alumni Registered', 'count' => $alumniStats['total_approved'], 'route' => '/admin/alumni', 'color' => 'text-emerald-600 bg-emerald-50 border-emerald-100'],
                ['title' => 'Inbound Inquiries', 'count' => $inquiryStats['total'], 'route' => '/admin/inquiries', 'color' => 'text-amber-600 bg-amber-50 border-amber-100'],
            ];
        @endphp
        @foreach($tiles as $tile)
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">{{ $tile['title'] }}</span>
                    <span class="text-3xl font-bold text-slate-900 block mt-2 tracking-tight">{{ $tile['count'] }}</span>
                </div>
                <a href="{{ $tile['route'] }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 mt-4">
                    Manage Board <span class="transform group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </a>
            </div>
        @endforeach
    </div>

    {{-- DYNAMIC CHART METRICS CONTAINER --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- NOTICE FREQUENCY CHART --}}
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-4">Notice Dispatch Frequency</h3>
            <div class="relative w-full h-48 bg-slate-50/50 rounded-xl border border-dashed border-slate-200 p-4 flex flex-col justify-between">
                @php
                    $maxNotice = max($noticeTrend->toArray() ?: [1]);
                    $points = '';
                    foreach($noticeTrend as $index => $val) {
                        $x = ($index * 110) + 25;
                        $y = 85 - (($val / $maxNotice) * 60);
                        $points .= "$x,$y ";
                    }
                @endphp
                <div class="absolute inset-0 p-4 pt-8 pb-10">
                    <svg class="w-full h-full overflow-visible" viewBox="0 0 600 100" preserveAspectRatio="none">
                        <polyline points="{{ trim($points) }}" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        @foreach($noticeTrend as $index => $val)
                            @php
                                $x = ($index * 110) + 25;
                                $y = 85 - (($val / $maxNotice) * 60);
                            @endphp
                            <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="#2563eb" class="cursor-pointer group"/>
                        @endforeach
                    </svg>
                </div>
                <div class="w-full flex justify-between text-[9px] font-mono text-slate-400 border-b border-slate-100 pb-10"><span>Peak Volume: {{ $maxNotice }}</span></div>
                <div class="w-full flex justify-between text-[10px] font-bold text-slate-400 uppercase pt-2 border-t border-slate-100 z-10">
                    @foreach($chartLabels as $label) <span>{{ $label }}</span> @endforeach
                </div>
            </div>
        </div>

        {{-- ALUMNI REGISTRATION DATA VISUALIZATION --}}
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-4">Alumni Acquisition Velocity</h3>
            <div class="w-full h-48 bg-slate-50/50 rounded-xl border border-dashed border-slate-200 p-4 flex flex-col justify-between">
                <div class="h-32 w-full flex items-end justify-between gap-4 px-2">
                    @php $maxAlumni = max($alumniTrend->toArray() ?: [1]); @endphp
                    @foreach($alumniTrend as $val)
                        @php $pct = ($val / $maxAlumni) * 100; @endphp
                        <div class="w-full bg-blue-600/90 hover:bg-blue-600 rounded-t-lg transition-all relative group" style="height: {{ max($pct, 8) }}%">
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition pointer-events-none shadow-md z-30 font-mono">
                                +{{ $val }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="w-full flex justify-between text-[10px] font-bold text-slate-400 uppercase pt-2 border-t border-slate-100">
                    @foreach($chartLabels as $label) <span>{{ $label }}</span> @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- BOTTOM FEED LAYERS: FEED PIPELINES VS REAL-TIME AUDIT LOG --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- RECENT NOTICES --}}
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm lg:col-span-1 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Recent Notices</h3>
                    <a href="/admin/notices" class="text-xs font-bold text-blue-600 hover:text-blue-700">View all</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse(\App\Models\Notice::latest()->take(3)->get() as $notice)
                        <div class="py-3 first:pt-0 last:pb-0">
                            <h4 class="text-sm font-semibold text-slate-800 line-clamp-1">{{ $notice->title }}</h4>
                            <span class="text-[11px] font-medium text-slate-400 block mt-0.5">{{ $notice->created_at->format('M d, Y') }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-4 italic">No active circular statements published.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- REAL-TIME AUDIT LOG TRAIL LEDGER (CRITICAL OPS LEDGER) --}}
        <div class="bg-white border border-slate-200 p-6 rounded-2xl shadow-sm lg:col-span-2 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">System Activity Ledger (Audit Trail)</h3>
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </div>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($auditLogs as $log)
                            <li>
                                <div class="relative pb-5">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-100" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-xl flex items-center justify-center text-sm {{ $log['bg'] }} ring-4 ring-white shadow-sm border border-slate-100">
                                                {{ $log['icon'] }}
                                            </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <p class="text-xs font-semibold text-slate-600">{{ $log['text'] }}</p>
                                            <div class="whitespace-nowrap text-right text-[10px] font-mono font-medium text-slate-400">
                                                {{ $log['time']->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <p class="text-xs text-slate-400 py-4 italic">No historical transactions verified inside execution memory loops yet.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- COMMAND PALETTE JAVASCRIPT CONTROLLER SUBENGINE --}}
<script>
    function toggleCommandPalette(show) {
        const palette = document.getElementById('command-palette');
        if (show) {
            palette.classList.remove('hidden');
            document.getElementById('palette-search').focus();
        } else {
            palette.classList.add('hidden');
        }
    }

    // Keyboard capture mechanism listener (Ctrl + K & Escape Key binding loops)
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            toggleCommandPalette(true);
        }
        if (e.key === 'Escape') {
            toggleCommandPalette(false);
        }
    });

    function filterPalette() {
        const input = document.getElementById('palette-search').value.toLowerCase();
        const li = document.getElementById('palette-results').getElementsByTagName('li');
        
        for (let i = 0; i < li.length; i++) {
            let text = li[i].textContent || li[i].innerText;
            if (text.toLowerCase().indexOf(input) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>
@endsection