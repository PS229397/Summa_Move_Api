<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        Log::info('Edit method called', ['request' => $request->all()]);

        $response = view('profile.edit', [
            'user' => $request->user(),
        ]);

        Log::info('Edit method completed', ['response' => $response]);

        return $response;
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Log::info('Update method called', ['request' => $request->all()]);

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $response = Redirect::route('profile.edit')->with('status', 'profile-updated');

//        Log::info('Update method completed', ['response' => $response]);

        return $response;
    }

    public function destroy(Request $request): RedirectResponse
    {
        Log::info('Destroy method called', ['request' => $request->all()]);

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $response = Redirect::to('/');

        Log::info('Destroy method completed', ['response' => $response]);

        return $response;
    }
}
