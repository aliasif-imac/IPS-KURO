namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Alumni;
use App\Models\Faculty;
use App\Models\Inquiry;

public function index()
{
    // 1. Core Metrics (Updated based on your SQL logs)
    $facultyStats = [
        'total'          => Faculty::count(),
        'teaching'       => Faculty::where('type', 'teaching')->count(),
        'administration' => Faculty::where('type', 'administration')->count(),
        'support'        => Faculty::where('type', 'support')->count(),
    ];

    $alumniStats = [
        'total_approved' => Alumni::where('status', 'approved')->count(),
        'pending_review' => Alumni::where('status', 'pending')->count(),
    ];

    $inquiryStats = [
        'total' => Inquiry::count(),
    ];

    // 2. Trend Calculations (Last 6 Months)
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

    $noticeTrend = $months->map(fn($m) => $noticeTrendData->get($m, 0));
    $alumniTrend = $months->map(fn($m) => $alumniTrendData->get($m, 0));
    $chartLabels = $months->map(fn($m) => date('M', strtotime($m . '-01')));

    // 3. Activity Ledger
    $auditLogs = collect()
        ->merge(Notice::latest()->take(3)->get()->map(fn($n) => [
            'text' => "System notice published: \"{$n->title}\"",
            'time' => $n->created_at,
            'icon' => '📢',
            'bg' => 'bg-blue-50 text-blue-600'
        ]))
        ->merge(Alumni::latest()->take(3)->get()->map(fn($a) => [
            'text' => "Alumni registry entry for {$a->name} updated",
            'time' => $a->created_at,
            'icon' => '🎓',
            'bg' => $a->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600'
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
}