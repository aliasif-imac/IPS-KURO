@extends('layouts.admin')

@section('admin_content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-950 border border-slate-800 p-6 rounded-2xl shadow-md">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-white">Circulars & Announcements</h1>
            <p class="text-xs text-slate-400 mt-1">Issue global notices, publish system directives, track memo logs, and broadcast important announcements to the public site feed.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
            <span class="bg-blue-900/40 text-blue-400 border border-blue-800 text-xs px-3 py-1 rounded-full font-mono font-bold">
                Total Published: {{ $notices->total() }}
            </span>
            <a href="#add-notice-modal" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition uppercase tracking-wider shadow-sm inline-block text-center">
                + Create Live Notice
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-red-950/80 border border-red-800 text-red-200 rounded-xl text-xs shadow-sm mt-4">
            <strong class="font-bold block mb-1">⚠️ System Validation Failed:</strong>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="p-4 bg-emerald-950 border border-emerald-800 text-emerald-400 rounded-xl text-xs font-semibold shadow-sm mt-4">
            ✔ {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4 mt-6">
        @if($notices->isEmpty())
            <div class="p-12 border border-dashed border-slate-800 bg-slate-950/20 rounded-2xl text-center text-slate-500 text-xs leading-relaxed">
                📢 No active circular announcements found inside the system database storage registry.
            </div>
        @else
            <div class="bg-slate-950 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-[10px] font-bold uppercase text-slate-500 bg-slate-950">
                            <th class="p-4">Circular Header / Context</th>
                            <th class="p-4">Date Issued</th>
                            <th class="p-4 text-right">Actions Matrix</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-900 text-xs font-medium text-slate-300">
                        @foreach($notices as $notice)
                            <tr class="hover:bg-slate-900/40 transition">
                                <td class="p-4 max-w-lg">
                                    <div class="text-white font-semibold text-sm tracking-tight">{{ $notice->title }}</div>
                                    <div class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed font-light whitespace-pre-line">{{ $notice->content }}</div>
                                </td>
                                <td class="p-4 text-slate-400 font-mono text-[11px]">
                                    {{ $notice->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex gap-2 justify-end items-center">
                                        <a href="#edit-notice-{{ $notice->id }}" class="bg-blue-900/60 hover:bg-blue-800 border border-blue-700/50 text-white font-bold text-[10px] uppercase tracking-wider px-3 py-1.5 rounded-lg transition inline-block">
                                            Edit
                                        </a>
                                        <form action="{{ route('notices.destroy', $notice->id) }}" method="POST" onsubmit="return confirm('Confirm permanent removal of this public announcement log?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-950 hover:bg-red-900 text-red-400 border border-red-900/50 font-bold text-[10px] uppercase tracking-wider px-3 py-1.5 rounded-lg transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- INTERACTIVE EDIT MODAL CONTAINER LOOP --}}
                            <div id="edit-notice-{{ $notice->id }}" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 pointer-events-none opacity-0 target:opacity-100 target:pointer-events-auto transition duration-200 flex items-center justify-center p-4">
                                <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden flex flex-col">
                                    <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center">
                                        <h3 class="text-white font-bold text-sm uppercase tracking-wider">Modify Circular Announcement</h3>
                                        <a href="#" class="text-slate-400 hover:text-white text-lg font-bold leading-none">&times;</a>
                                    </div>
                                    <form action="{{ route('notices.update', $notice->id) }}" method="POST" class="p-5 space-y-4 text-left">
                                        @csrf
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Notice Header Title *</label>
                                            <input type="text" name="title" value="{{ old('title', $notice->title) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Announcement Content *</label>
                                            <textarea name="content" rows="6" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition font-sans leading-relaxed">{{ old('content', $notice->content) }}</textarea>
                                        </div>
                                        <div class="pt-2 border-t border-slate-800/60 flex justify-end gap-2">
                                            <a href="#" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs py-2 px-4 rounded-xl transition uppercase tracking-wider">Cancel</a>
                                            <button type="submit" class="bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs py-2 px-5 rounded-xl transition uppercase tracking-wider shadow-sm">Update Broadcast</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 bg-slate-950 border border-slate-800 p-4 rounded-2xl shadow-md">
                {{ $notices->links() }}
            </div>
        @endif
    </div>

    {{-- INTERACTIVE GLOBAL ADD MODAL COMPONENT WINDOW --}}
    <div id="add-notice-modal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 pointer-events-none opacity-0 target:opacity-100 target:pointer-events-auto transition duration-200 flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center">
                <h3 class="text-white font-bold text-sm uppercase tracking-wider">Publish Global School Announcement</h3>
                <a href="#" class="text-slate-400 hover:text-white text-lg font-bold leading-none">&times;</a>
            </div>
            <form action="{{ route('notices.store') }}" method="POST" class="p-5 space-y-4 text-left">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Notice Header Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Midterm Examination Schedule 2026" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Announcement Content Details *</label>
                    <textarea name="content" rows="6" required placeholder="Type all structural instructions, timings, or description rows here..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition font-sans leading-relaxed">{{ old('content') }}</textarea>
                </div>
                <div class="pt-2 border-t border-slate-800/60 flex justify-end gap-2">
                    <a href="#" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs py-2 px-4 rounded-xl transition text-center uppercase tracking-wider">Cancel</a>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs py-2 px-5 rounded-xl transition uppercase tracking-wider shadow-sm">Publish to Live Board</button>
                </div>
            </form>
        </div>
    </div>

@endsection