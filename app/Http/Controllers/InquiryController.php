<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Public View: Show approved alumni on the Wall of Fame
     */
    public function publicIndex()
    {
        $alumni = Alumni::where('status', 'approved')
                        ->orderBy('graduation_year', 'desc')
                        ->get();

        return view('public.alumni.index', compact('alumni'));
    }

    /**
     * Public View: Show the self-registration form wizard
     */
    public function create()
    {
        return view('public.alumni.register');
    }

    /**
     * Public Intake Action: Save a profile submission as 'pending'
     */
    public function store(Request $request)
    {
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

        $validated['status'] = 'pending'; // Enforce verification queue workflow[cite: 1]

        Alumni::create($validated);

        return redirect()->route('alumni.index')->with('success', 'Your registration has been submitted successfully! It will be visible on the Wall of Fame once verified by the school administration.');
    }

    /**
     * Admin CPanel: List all pending and verified alumni records[cite: 1]
     */
    public function adminIndex()
    {
        $pendingAlumni = Alumni::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $approvedAlumni = Alumni::where('status', 'approved')->orderBy('graduation_year', 'desc')->get();
        
        return view('admin.alumni.index', compact('pendingAlumni', 'approvedAlumni'));
    }

    /**
     * Admin CPanel Action: Approve or Reject a profile status[cite: 1]
     */
    public function updateStatus(Request $request, Alumni $alumni)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $alumni->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Alumni status updated to ' . $request->status . ' successfully.');
    }
}