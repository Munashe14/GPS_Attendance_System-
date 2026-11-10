<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RegionalCentre;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register', [
            'roles' => ['Student', 'Lecturer', 'RegionalAdmin', 'SysAdmin', 'Other'],
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'role' => ['required', 'string', Rule::in(['Student', 'Lecturer', 'RegionalAdmin', 'SysAdmin', 'Other'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 'Active',
        ]);

        if ($request->role === 'Student') {
            $centre = RegionalCentre::query()->first();

            if (!$centre) {
                $centre = RegionalCentre::create([
                    'centre_name' => 'Default Regional Centre',
                    'province' => 'Default',
                    'latitude' => -17.8272,
                    'longitude' => 31.0539,
                    'radius_m' => 100,
                    'status' => 'Active',
                ]);
            }

            $studentNumber = (Student::max('student_id') ?? 0) + 1;

            $student = Student::create([
                'pin' => 'STU' . str_pad((string) $studentNumber, 6, '0', STR_PAD_LEFT),
                'full_name' => ucfirst($request->username),
                'programme' => 'General',
                'zou_email' => Str::slug($request->username, '') . $studentNumber . '@student.local',
                'phone' => '0000000000',
                'centre_id' => $centre->centre_id,
                'status' => 'Active',
            ]);

            $user->update(['linked_id' => $student->student_id]);
        }

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Account created successfully. Please log in.');
    }
}
