<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;



class ProfileController extends Controller
{
    public function setup()
    {
        return view('auth.profile_setup');
    }

    public function update(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validated();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('public/profile_images');
            $user->profile_image = basename($path);
        }
        
        $user->name = $validated['name'];
        $user->postal_code = $validated['postal_code'];
        $user->address = $validated['address'];
        $user->save();

        return redirect()->route('index')->with('status', 'プロフィールを更新しました！');
    }

    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('mypage.profile_edit', compact('user'));
    }

    public function edit(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validated();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('public/profile_images');
            $user->profile_image = basename($path);
        }
        
        $user->name = $validated['name'];
        $user->postal_code = $validated['postal_code'];
        $user->address = $validated['address'];
        $user->save();

        return redirect()->route('index')->with('status', 'プロフィールを更新しました！');
    }
}
