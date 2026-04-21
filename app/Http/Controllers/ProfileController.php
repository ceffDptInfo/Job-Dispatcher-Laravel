<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $oldName = $user->getOriginal('name');
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($user->isDirty('name')) {
            $basePath = config('services.nfs.path');
            
            $oldFolderName = Str::slug($user->id_user) . '-' . Str::slug($oldName);
            $newFolderName = Str::slug($user->id_user) . '-' . Str::slug($user->name);
            
            $oldPath = $basePath . DIRECTORY_SEPARATOR . $oldFolderName;
            $newPath = $basePath . DIRECTORY_SEPARATOR . $newFolderName;

            if (File::exists($oldPath)) {
                File::move($oldPath, $newPath);
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $basePath = config('services.nfs.path');
        $folderName = Str::slug($user->id_user) . '-' . Str::slug($user->name);
        $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $folderName;

        if(File::exists($userFolderPath)) {
            File::deleteDirectory($userFolderPath);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('home');
    }
}
