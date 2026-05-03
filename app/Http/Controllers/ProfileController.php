<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Support\ImsMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'menuItems' => ImsMenu::moduleNav($request->user()),
            'navActive' => 'profile',
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->filled('password') && ! Hash::check($request->string('current_password'), $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        $user->name = $request->validated('name');
        $user->email = $request->validated('email');

        if ($request->filled('password')) {
            $user->password = $request->validated('password');
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Your profile was updated.');
    }
}
