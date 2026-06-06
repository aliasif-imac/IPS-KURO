@extends('layouts.admin')

@section('admin_content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-950 border border-slate-800 p-6 rounded-2xl shadow-md">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-white">Incoming General Enquiries</h1>
            <p class="text-xs text-slate-400 mt-1">Review communication logs, support messages, and admissions intake forms sent by public visitors.</p>
        </div>
        <span class="bg-blue-900/40 text-blue-400 border border-blue-800 text-xs px-3 py-1 rounded-full font-mono font-bold">
            Total Logged: {{ $inquiries->total() }}
        </span>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-950 border border-emerald-800 text-emerald-400 rounded-xl text-xs font-semibold shadow-sm">
            ✔ {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.inquiries.index') }}" class="bg-slate-950 border border-slate-800 p-4 rounded-2xl grid grid-cols-1 sm:grid-cols-3 gap-4 items-end shadow-md">
        <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Search Correspondence</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter by sender name, email string, or subject text..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-grow bg-blue-900 hover:bg-blue-800 border border-blue-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl transition uppercase tracking-wider shadow-sm">
                Filter Logs
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.inquiries.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs py-2.5 px-3 rounded-xl transition text-center flex items-center justify-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <div class="space-y-4">
        @if($inquiries->isEmpty())
            <div class="p-12 border border-dashed border-slate-800 bg-slate-950/20 rounded-2xl text-center text-slate-500 text-xs leading-relaxed">
                📥 No visitor messages matched your tracking criteria or your inbox is entirely empty.
            </div>
        @else
            <div class="space-y-3">
                @foreach($inquiries as $message)
                    <div class="bg-slate-950 border border-slate-800 rounded-2xl p-5 hover:border-slate-700 transition space-y-4">
                        
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-900 pb-3 gap-2">
                            <div>
                                <h4 class="font-bold text-white text-base leading-tight">{{ $message->sender_name }}</h4>
                                <p class="text-xs text-blue-400 font-medium mt-0.5 font-mono">{{ $message->sender_email }}</p>
                            </div>
                            <div class="text-right flex flex-col items-start sm:items-end">
                                <span class="text-[10px] bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-md text-slate-400 font-mono">
                                    📅 {{ $message->created_at->format('M d, Y \a\t h:i A') }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="text-xs uppercase tracking-wider text-slate-400 font-bold">
                                <span class="text-slate-600 mr-1">Subject:</span> {{ $message->subject }}
                            </div>
                            <div class="bg-slate-900/60 border border-slate-800/60 rounded-xl p-4 text-xs text-slate-300 leading-relaxed whitespace-pre-wrap">
                                {{ $message->message }}
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>

            <div class="mt-6 bg-slate-950 border border-slate-800 p-4 rounded-2xl shadow-md">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>

@endsection