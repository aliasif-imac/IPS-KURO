@extends('layouts.public')

@section('content')

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-16">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">
            
            <div class="bg-gradient-to-r from-blue-950 to-blue-900 p-8 text-white text-center sm:text-left">
                <h2 class="text-2xl font-bold tracking-tight">Join the Alumni Network Directory</h2>
                <p class="text-sm text-blue-200 mt-1 font-light">
                    Your achievements inspire the next generation of students in Kuro. Fill out your current tracking data below.
                </p>
            </div>

            @if($errors->any())
                <div class="p-5 bg-red-50 border-b border-red-100 text-xs font-medium text-red-700 space-y-1">
                    <p class="font-bold mb-1 text-sm text-red-800">Please correct the highlighted inputs below:</p>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('alumni.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                
                <div class="border-b border-slate-100 pb-5">
                    <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wider mb-4">1. Personal Profile</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Your Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Graduation Year (Middle School) *</label>
                            <select name="graduation_year" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm bg-white">
                                <option value="">Select Year</option>
                                @for($year = date('Y'); $year >= 1998; $year--)
                                    <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-b border-slate-100 pb-5">
                    <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wider mb-4">2. Contact Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Phone Number (Optional)</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                        </div>
                    </div>
                </div>

                <div class="border-b border-slate-100 pb-5">
                    <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wider mb-4">3. Professional Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Current Profession / Title *</label>
                            <input type="text" name="current_profession" placeholder="e.g., Software Engineer, Medical Doctor, Educator" value="{{ old('current_profession') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Current Company / Organization</label>
                            <input type="text" name="current_organization" placeholder="e.g., Hospital, Tech Firm, Government Department" value="{{ old('current_organization') }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Current City *</label>
                            <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Current Country *</label>
                            <input type="text" name="country" value="{{ old('country', 'Pakistan') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wider mb-4">4. School Testimonial & Portrait</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Profile Picture (Portrait JPG/PNG, Max 2MB)</label>
                            <input type="file" name="profile_image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:uppercase file:bg-blue-50 file:text-blue-900 hover:file:bg-blue-100 transition file:cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Memory / Message about your time at Kuro School</label>
                            <textarea name="testimonial" rows="4" placeholder="Briefly describe your school journey or offer advice to current children studying at Kuro..." class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:border-blue-900 transition text-sm">{{ old('testimonial') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-4 rounded-lg tracking-wider uppercase text-xs transition shadow-md">
                        Submit Profile for Verification
                    </button>
                    <span class="block text-center text-[11px] text-slate-400 mt-3 font-medium">
                        * Note: To preserve information security, your record will display publicly on the Wall of Fame only after administrative validation inside the school CPanel.
                    </span>
                </div>
            </form>
        </div>
    </div>

@endsection