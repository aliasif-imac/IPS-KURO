@extends('layouts.admin')

@section('admin_content')

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-950 border border-slate-800 p-6 rounded-2xl shadow-md">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-white">Faculty Lifecycle Roster</h1>
            <p class="text-xs text-slate-400 mt-1">Manage public directory profiles, categorize organizational domains, track staff status, and log career path movements.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
            <span class="bg-blue-900/40 text-blue-400 border border-blue-800 text-xs px-3 py-1 rounded-full font-mono font-bold">
                Total Registered: {{ $faculties->total() }}
            </span>
            <a href="#add-faculty-modal" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition uppercase tracking-wider shadow-sm inline-block text-center">
                + Register New Faculty
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

    <form method="GET" action="{{ route('admin.faculty.index') }}" class="bg-slate-950 border border-slate-800 p-4 rounded-2xl grid grid-cols-1 sm:grid-cols-3 gap-4 items-end shadow-md mt-6">
        <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Filter Staff Directory</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, designation, qualification..." class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-grow bg-blue-900 hover:bg-blue-800 border border-blue-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl transition uppercase tracking-wider shadow-sm">
                Apply Search Matrix
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.faculty.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs py-2.5 px-3 rounded-xl transition text-center flex items-center justify-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <div class="space-y-4 mt-6">
        @if($faculties->isEmpty())
            <div class="p-12 border border-dashed border-slate-800 bg-slate-950/20 rounded-2xl text-center text-slate-500 text-xs leading-relaxed">
                👨‍🏫 No instructor or staff profiles matched your filter parameters.
            </div>
        @else
            <div class="bg-slate-950 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-[10px] font-bold uppercase text-slate-500 bg-slate-950">
                            <th class="p-4">Staff Member</th>
                            <th class="p-4">Classification Group</th>
                            <th class="p-4">Display Weight</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-900 text-xs font-medium text-slate-300">
                        @foreach($faculties as $member)
                            <tr class="hover:bg-slate-900/40 transition {{ $member->lifecycle_status === 'left' ? 'opacity-50 bg-slate-950/40' : '' }}">
                                <td class="p-4 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                        @if(!empty($member->image_path))
                                            <img src="{{ asset('storage/' . $member->image_path) }}" class="w-full h-full object-cover" alt="">
                                        @else
                                            <span class="text-slate-500 font-mono font-bold uppercase text-xs">{{ substr($member->name, 0, 2) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-white font-semibold text-sm flex items-center gap-2">
                                            {{ $member->name }}
                                            @if($member->lifecycle_status === 'left')
                                                <span class="bg-red-950 border border-red-800 text-red-400 text-[9px] px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Archived / Left</span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-blue-400 mt-0.5 font-medium tracking-wide uppercase">{{ $member->designation }}</div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-900 border border-slate-800 text-slate-400">
                                        @if($member->type === 'teaching') 🎓 Teaching @elseif($member->type === 'administration') 🏢 Admin @elseif($member->type === 'visiting') 💼 Visiting @else 🤝 Support @endif
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="font-mono text-slate-400">Index: {{ $member->sort_order }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    @if($member->lifecycle_status === 'active')
                                        <span class="text-[10px] uppercase tracking-wider font-bold text-emerald-400 bg-emerald-950/50 border border-emerald-900 px-2.5 py-1 rounded-lg">Active</span>
                                    @else
                                        <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400 bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-lg">Hidden From Public</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <a href="#edit-faculty-{{ $member->id }}" class="bg-blue-900/60 hover:bg-blue-800 border border-blue-700/50 text-white font-bold text-[10px] uppercase tracking-wider px-3 py-1.5 rounded-lg transition inline-block">
                                        Edit / Status
                                    </a>
                                </td>
                            </tr>

                            <div id="edit-faculty-{{ $member->id }}" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 pointer-events-none opacity-0 target:opacity-100 target:pointer-events-auto transition duration-200 flex items-center justify-center p-4">
                                <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden flex flex-col">
                                    
                                    <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center">
                                        <h3 class="text-white font-bold text-sm uppercase tracking-wider">Update Profile Metrics: {{ $member->name }}</h3>
                                        <a href="#" class="text-slate-400 hover:text-white text-lg font-bold leading-none">&times;</a>
                                    </div>

                                    <form action="{{ route('admin.faculty.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4 text-left">
                                        @csrf
                                        
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Full Name *</label>
                                            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Designation * (Changing logs promotions)</label>
                                                <input type="text" name="designation" value="{{ old('designation', $member->designation) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Classification Type *</label>
                                                <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                                                    <option value="teaching" {{ $member->type === 'teaching' ? 'selected' : '' }}>🎓 Teaching Faculty</option>
                                                    <option value="administration" {{ $member->type === 'administration' ? 'selected' : '' }}>🏢 Administration</option>
                                                    <option value="visiting" {{ $member->type === 'visiting' ? 'selected' : '' }}>💼 Visiting Faculty</option>
                                                    <option value="support" {{ $member->type === 'support' ? 'selected' : '' }}>🤝 Support Staff</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Academic Qualification *</label>
                                                <input type="text" name="qualification" value="{{ old('qualification', $member->qualification) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Lifecycle Status *</label>
                                                <select name="lifecycle_status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                                                    <option value="active" {{ $member->lifecycle_status === 'active' ? 'selected' : '' }}>🟢 Active (Visible on Site)</option>
                                                    <option value="left" {{ $member->lifecycle_status === 'left' ? 'selected' : '' }}>🔴 Left Institution (Hidden from Public)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Display Sort Weight</label>
                                            <input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition font-mono">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Replace Profile Photo (Optional)</label>
                                            <input type="file" name="faculty_image" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-1.5 text-xs text-slate-400 focus:outline-none focus:border-blue-500 transition file:mr-4 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-slate-800 file:text-slate-200">
                                        </div>

                                        <div class="pt-2 border-t border-slate-800/60 flex justify-end gap-2">
                                            <a href="#" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs py-2 px-4 rounded-xl transition uppercase tracking-wider">Cancel</a>
                                            <button type="submit" class="bg-blue-700 hover:bg-blue-600 text-white font-bold text-xs py-2 px-5 rounded-xl transition uppercase tracking-wider shadow-sm">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 bg-slate-950 border border-slate-800 p-4 rounded-2xl shadow-md">
                {{ $faculties->links() }}
            </div>
        @endif
    </div>

    <div id="add-faculty-modal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 pointer-events-none opacity-0 target:opacity-100 target:pointer-events-auto transition duration-200 flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden flex flex-col">
            
            <div class="p-5 border-b border-slate-800 bg-slate-950 flex justify-between items-center">
                <h3 class="text-white font-bold text-sm uppercase tracking-wider">Register New Faculty Profile</h3>
                <a href="#" class="text-slate-400 hover:text-white text-lg font-bold leading-none">&times;</a>
            </div>

            <form action="{{ route('admin.faculty.store') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4 text-left">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Professor Shah Wali" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Designation *</label>
                        <input type="text" name="designation" value="{{ old('designation') }}" required placeholder="e.g. Senior Lecturer" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Classification Domain *</label>
                        <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition">
                            <option value="teaching" selected>🎓 Teaching Faculty</option>
                            <option value="administration">🏢 Administration</option>
                            <option value="visiting">💼 Visiting Faculty</option>
                            <option value="support">🤝 Support Staff</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Academic Qualification *</label>
                        <input type="text" name="qualification" value="{{ old('qualification') }}" required placeholder="e.g. M.Phil in English" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Initial Lifecycle Status *</label>
                        <select name="lifecycle_status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition">
                            <option value="active" selected>🟢 Active (Visible Immediately)</option>
                            <option value="left">🔴 Left / Hold (Hidden)</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Display Order Weight * (Lower numbers show first)</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 transition font-mono">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-0.5">Profile Photo Asset (Optional)</label>
                    <input type="file" name="faculty_image" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-1.5 text-xs text-slate-400 focus:outline-none focus:border-blue-500 transition file:mr-4 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-slate-800 file:text-slate-200">
                </div>

                <div class="pt-2 border-t border-slate-800/60 flex justify-end gap-2">
                    <a href="#" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs py-2 px-4 rounded-xl transition text-center uppercase tracking-wider">Cancel</a>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs py-2 px-5 rounded-xl transition uppercase tracking-wider shadow-sm">Save Profile</button>
                </div>
            </form>
        </div>
    </div>

@endsection