<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        try {
            // Safe role checking and routing
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('teacher')) {
                return redirect()->route('teacher.dashboard');
            } elseif ($user->hasRole('student')) {
                return redirect()->route('student.dashboard');
            }
        } catch (\Exception $e) {
            // If roles table doesn't exist, fail gracefully
            return response()->view('welcome')->with('error', 'Database not fully migrated. Please run migrations.');
        }

        // If user has no roles but is logged in, show a pending/unauthorized screen
        abort(403, 'Your account is pending role assignment. Please contact an administrator.');
    }
}
