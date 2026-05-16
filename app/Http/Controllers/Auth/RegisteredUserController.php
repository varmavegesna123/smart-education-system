<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            // Check if roles table exists to prevent crash on fresh unmigrated setups
            if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
                // Ensure 'student' role exists
                $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'student']);
                $user->assignRole($role);
                
                // Also create a Student record to prevent relational crashes in dashboards
                \App\Models\Student::firstOrCreate([
                    'user_id' => $user->id
                ], [
                    'enrollment_number' => 'STU' . time(),
                    'risk_level' => 'Safe'
                ]);
            }
        } catch (\Exception $e) {
            // Fail gracefully if Spatie is not fully migrated
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
