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
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'last_name'   => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'first_name'  => ['required', 'string', 'max:100'],
            'employee_id' => ['nullable', 'string', 'max:50', 'unique:'.User::class.',employee_id'],
            'phone'       => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9 \-()]{7,20}$/'],
            'department'  => ['nullable', 'string', 'max:100'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.regex' => 'Phone number may only contain digits, spaces, +, -, or ( ). Letters are not allowed.',
        ]);

        $fullName = trim(collect([
            $data['first_name'],
            $data['middle_name'] ?? null,
            $data['last_name'],
        ])->filter()->implode(' '));

        $user = User::create([
            'name'        => $fullName,
            'first_name'  => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name'   => $data['last_name'],
            'employee_id' => $data['employee_id'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'department'  => $data['department'] ?? null,
            'role'        => User::ROLE_SUPPORT,
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
