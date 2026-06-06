<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Notice;
use App\Models\Faculty;
use App\Models\FacultyLog;
use App\Models\Inquiry;

/*
|--------------------------------------------------------------------------
| PUBLIC FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// Institutional Landing Page View (With Live Dynamic Notice Board Injection)
Route::get('/', function () { 
    // Fetch latest active notices to feed directly into the homepage layout widget block
    $notices = Notice::latest()->get();
    return view('public.home', compact('notices')); 
})->name('home');

// Dedicated Standalone Public Faculty Directory Page (Lifecycle & Type Aware)
Route::get('/faculty', function () {
    // Only pull active staff members, sorted by display weights, and group them by type
    $faculties = Faculty::where('lifecycle_status', 'active')
                        ->orderBy('sort_order', 'asc')
                        ->orderBy('name', 'asc')
                        ->get()
                        ->groupBy('type'); // Splits into collections: teaching, administration, etc.
                        
    return view('public.faculty', compact('faculties'));
})->name('public.faculty');

// Historical About Segment View (Dynamic Principal Injection)
Route::get('/about', function () { 
    // Query the database for an active profile designated as 'Principal'
    $principal = Faculty::where('lifecycle_status', 'active')
        ->where(function($q) {
            $q->where('designation', 'Principal')
              ->orWhere('designation', 'LIKE', '%Principal%');
        })
        ->first();

    return view('public.about', compact('principal'));
})->name('about');

// Notice Circular Board Feed View
Route::get('/notices', function () {
    $notices = Notice::orderBy('created_at', 'desc')->get();
    return view('public.notices', compact('notices'));
})->name('public.notices');


/*
|--------------------------------------------------------------------------
| ALUMNI HUB PUBLIC FEED DIRECT INJECTIONS
|--------------------------------------------------------------------------
*/

// Alumni Mosaic Wall of Fame Feed (With Search, Sorting & Pagination)
Route::get('/alumni', function (Request $request) {
    $query = Alumni::where('status', 'approved');

    // 1. Filter by Search Keyword (Name, Profession, Organization, City)
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('current_profession', 'LIKE', "%{$search}%")
              ->orWhere('current_organization', 'LIKE', "%{$search}%")
              ->orWhere('city', 'LIKE', "%{$search}%");
        });
    }

    // 2. Filter explicitly by graduation year
    if ($request->filled('year')) {
        $query->where('graduation_year', $request->input('year'));
    }

    // 3. Apply Sorting System
    $sortBy = $request->input('sort', 'year_desc'); 
    switch ($sortBy) {
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;
        case 'year_asc':
            $query->orderBy('graduation_year', 'asc');
            break;
        case 'year_desc':
        default:
            $query->orderBy('graduation_year', 'desc');
            break;
    }

    // 4. Paginate results safely (12 profiles per page)
    $alumni = $query->paginate(12)->withQueryString();

    // Get unique graduation years for filter options
    $availableYears = Alumni::where('status', 'approved')
                            ->select('graduation_year')
                            ->distinct()
                            ->orderBy('graduation_year', 'desc')
                            ->pluck('graduation_year');

    return view('public.alumni.index', compact('alumni', 'availableYears'));
})->name('alumni.index');

// Alumni Hub Self-Registration Entry Wizard
Route::get('/alumni/register', function () {
    return view('public.alumni.register');
})->name('alumni.register');

// Form Data Processing Intake Route
Route::post('/alumni/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'graduation_year' => 'required|integer|between:1998,' . date('Y'),
        'current_profession' => 'required|string|max:255',
        'current_organization' => 'nullable|string|max:255',
        'city' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'email' => 'required|email|unique:alumni,email',
        'phone_number' => 'nullable|string|max:20',
        'testimonial' => 'nullable|string|max:1000',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('alumni', 'public');
        $validated['profile_image_path'] = $path;
    }

    unset($validated['profile_image']);
    $validated['status'] = 'pending'; 

    Alumni::create($validated);

    return redirect()->route('alumni.index')->with('success', 'Your registration has been submitted successfully! It will be visible on the Wall of Fame once verified by the school administration.');
})->name('alumni.store');


/*
|--------------------------------------------------------------------------
| INCOMING GENERAL ENQUIRIES / CONTACT MESSAGE RECORD INTAKE
|--------------------------------------------------------------------------
*/
Route::post('/inquiry/send', function (Request $request) {
    $validated = $request->validate([
        'sender_name' => 'required|string|max:255',
        'sender_email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ]);

    Inquiry::create($validated);

    return redirect()->back()->with('success', 'Thank you! Your message has been recorded. The school administration will reach back out shortly.');
})->name('inquiry.store');


/*
|--------------------------------------------------------------------------
| SECURITY CHECKPOINT: EXPLICIT LOGGED-OUT GUEST HANDLER
|--------------------------------------------------------------------------
*/
// Intercept direct dashboard hits while unauthenticated and force them to the login form
Route::get('/admin/dashboard', function () {
    return redirect('/login');
})->middleware('guest');


/*
|--------------------------------------------------------------------------
| SECURE CPANEL ROUTES (Protected by Authentication Guards)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    
    // Core Admin Metrics Overview Interface (The Live Dashboard Tab Component)
    Route::get('/dashboard', function () {
        // 1. Dynamic Core Counts Compilation
        $facultyStats = [
            'total'          => Faculty::count(),
            'teaching'       => Faculty::where('type', 'teaching')->count(),
            'administration' => Faculty::where('type', 'administration')->count(),
            'support'        => Faculty::where('type', 'support')->count(),
            'visiting'       => Faculty::where('type', 'visiting')->count(),
        ];

        $alumniStats = [
            'total_approved' => Alumni::where('status', 'approved')->count(),
            'pending_review' => Alumni::where('status', 'pending')->count(),
        ];

        $inquiryStats = [
            'total' => Inquiry::count(),
        ];

        // 2. Real Monthly Analytical Aggregations (Last 6 Months Range Builder)
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('Y-m'));
        
        $noticeTrendData = Notice::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->pluck('count', 'month');

        $alumniTrendData = Alumni::where('status', 'approved')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, count(*) as count")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->pluck('count', 'month');

        // Map database counts securely into array slots matching their key months
        $noticeTrend = $months->map(fn($m) => $noticeTrendData->get($m, 0));
        $alumniTrend = $months->map(fn($m) => $alumniTrendData->get($m, 0));
        $chartLabels = $months->map(fn($m) => date('M', strtotime($m . '-01')));

        // 3. Dynamic Real-Time Operational Audit Log Engine
        $auditLogs = collect()
            ->merge(Notice::latest()->take(3)->get()->map(fn($n) => [
                'text' => "System notice published: \"{$n->title}\"",
                'time' => $n->created_at,
                'icon' => '📢',
                'bg' => 'bg-blue-50 text-blue-600'
            ]))
            ->merge(Alumni::latest()->take(3)->get()->map(fn($a) => [
                'text' => "Alumni record entry updated for {$a->name} (Status: " . ucfirst($a->status) . ")",
                'time' => $a->created_at,
                'icon' => '🎓',
                'bg' => $a->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600'
            ]))
            ->merge(Inquiry::latest()->take(2)->get()->map(fn($i) => [
                'text' => "Inbound query message received from \"{$i->sender_name}\"",
                'time' => $i->created_at,
                'icon' => '✉️',
                'bg' => 'bg-purple-50 text-purple-600'
            ]))
            ->sortByDesc('time')
            ->take(5);

        return view('admin.dashboard', compact(
            'facultyStats', 
            'alumniStats', 
            'inquiryStats', 
            'noticeTrend', 
            'alumniTrend', 
            'chartLabels',
            'auditLogs'
        ));
    })->name('admin.dashboard');
    
    // --- ALUMNI MODERATION GATEWAY QUEUE ---
    Route::get('/alumni', function (Request $request) {
        $pendingAlumni = Alumni::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $approvedQuery = Alumni::where('status', 'approved');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $approvedQuery->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('current_profession', 'LIKE', "%{$search}%");
            });
        }

        $sortBy = $request->input('sort', 'year_desc');
        switch ($sortBy) {
            case 'name_asc': 
                $approvedQuery->orderBy('name', 'asc'); 
                break;
            case 'name_desc': 
                $approvedQuery->orderBy('name', 'desc'); 
                break;
            case 'year_asc': 
                $approvedQuery->orderBy('graduation_year', 'asc'); 
                break;
            case 'year_desc': 
            default: 
                $approvedQuery->orderBy('graduation_year', 'desc'); 
                break;
        }

        $approvedAlumni = $approvedQuery->paginate(20)->withQueryString();

        return view('admin.alumni.index', compact('pendingAlumni', 'approvedAlumni'));
    })->name('admin.alumni.index');

    Route::patch('/alumni/{alumni}/status', function (Request $request, Alumni $alumni) {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $alumni->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Alumni record metrics updated to status: ' . strtoupper($request->status));
    })->name('admin.alumni.status');
    
    // --- NOTICES MANAGEMENT DESK CRUD CLOSURES ---
    Route::get('/notices', function () {
        $notices = Notice::latest()->paginate(10);
        return view('admin.notices.index', compact('notices'));
    })->name('notices.index');

    Route::post('/notices', function (Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        $validated['user_id'] = auth()->id();

        Notice::create($validated);

        return redirect()->route('notices.index')->with('success', 'Circular notice published successfully onto live boards!');
    })->name('notices.store');

    Route::post('/notices/{notice}/update', function (Request $request, Notice $notice) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $notice->update($validated);

        return redirect()->route('notices.index')->with('success', 'Circular notice updated successfully!');
    })->name('notices.update');

    Route::delete('/notices/{notice}', function (Notice $notice) {
        $notice->delete();
        return redirect()->route('notices.index')->with('success', 'Notice entry removed permanently from logs.');
    })->name('notices.destroy');

    // --- SECURE ACADEMIC FACULTY CONTROL PANEL ---
    Route::get('/faculty', function (Request $request) {
        $query = Faculty::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('designation', 'LIKE', "%{$search}%")
                  ->orWhere('qualification', 'LIKE', "%{$search}%");
            });
        }

        // Show active staff members first, sorting left/inactive profiles to the bottom
        $faculties = $query->orderBy('lifecycle_status', 'asc')
                           ->orderBy('sort_order', 'asc')
                           ->paginate(15)
                           ->withQueryString();

        return view('admin.faculty.index', compact('faculties'));
    })->name('admin.faculty.index');

    Route::post('/faculty/store', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'required|in:teaching,administration,support,visiting',
            'lifecycle_status' => 'required|in:active,left',
            'sort_order' => 'required|integer|min:0',
            'faculty_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['image_path'] = null;

        if ($request->hasFile('faculty_image')) {
            $path = $request->file('faculty_image')->store('faculty', 'public');
            $validated['image_path'] = $path;
        }
        
        unset($validated['faculty_image']);

        Faculty::create($validated);

        return redirect()->route('admin.faculty.index')->with('success', 'New faculty profile has been successfully integrated into the active school roster!');
    })->name('admin.faculty.store');

    Route::post('/faculty/{faculty}/update', function (Request $request, Faculty $faculty) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'required|in:teaching,administration,support,visiting',
            'lifecycle_status' => 'required|in:active,left',
            'sort_order' => 'required|integer|min:0',
            'faculty_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Auto Log Promotion Milestones
        if ($faculty->designation !== $request->designation) {
            FacultyLog::create([
                'faculty_id' => $faculty->id,
                'event_type' => 'promotion',
                'old_value' => $faculty->designation,
                'new_value' => $request->designation,
                'notes' => 'Assigned/Promoted to new institutional role designation.',
            ]);
        }

        // Auto Log Active Lifecycle Status Shifts
        if ($faculty->lifecycle_status !== $request->lifecycle_status) {
            FacultyLog::create([
                'faculty_id' => $faculty->id,
                'event_type' => 'status_change',
                'old_value' => $faculty->lifecycle_status,
                'new_value' => $request->lifecycle_status,
                'notes' => $request->lifecycle_status === 'left' ? 'Marked as departed. Profile hidden from public interface.' : 'Profile re-activated.',
            ]);
        }

        if ($request->hasFile('faculty_image')) {
            $path = $request->file('faculty_image')->store('faculty', 'public');
            $validated['image_path'] = $path;
        }
        unset($validated['faculty_image']);

        $faculty->update($validated);

        return redirect()->route('admin.faculty.index')->with('success', 'Faculty profile metrics and career path logs updated successfully.');
    })->name('admin.faculty.update');
    
    // --- PARENT COMMUNICATION MAILBOX VIEWER ---
    Route::get('/inquiries', function (Request $request) {
        $query = Inquiry::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('sender_name', 'LIKE', "%{$search}%")
                  ->orWhere('sender_email', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%");
            });
        }

        $query->orderBy('created_at', 'desc');
        $inquiries = $query->paginate(15)->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    })->name('admin.inquiries.index');
});

require __DIR__.'/auth.php';