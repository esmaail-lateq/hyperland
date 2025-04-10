<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:1024'], // 1MB Max
        ]);

        $user = $request->user();

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        // Store the new avatar
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update([
            'avatar' => $path,
        ]);

        return back()->with('success', 'Avatar updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        $user->update([
            'avatar' => null,
        ]);

        return back()->with('success', 'Avatar removed successfully!');
    }
}
