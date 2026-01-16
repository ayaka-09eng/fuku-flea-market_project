<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function store(ProfileRequest $request) {
        $user = auth()->user();
        $user->update(['name' => $request->name]);
        $profileData = $request->only(['postal_code', 'address', 'building']);
        if ($request->hasFile('img_path')) {
            $profileData['img_path'] = $request->file('img_path')->store('profiles', 'public');
        }
        $user->profile()->create($profileData);
        return redirect()->route('items.index');
    }

    public function mypage(Request $request) {
        $page = $request->query('page', 'sell');

        $user = auth()->user();
        $profile = $user->profile;

        if ($page === 'buy') {
            $items = $user->orders()->with('item')->orderBy('created_at', 'desc')->get()->pluck('item');
        } else {
            $items = $user->items()->orderBy('created_at', 'desc')->get();
        }

        return view('users.mypage', compact('user', 'profile', 'items', 'page'));
    }

    public function edit() {
        $user = auth()->user();
        $profile = $user->profile;
        return view('users.edit', compact('user', 'profile'));
    }

    public function update(ProfileRequest $request) {
        $user = auth()->user();
        $user->update(['name' => $request->name]);

        $profile = $user->profile;
        $profileData = $request->only(['postal_code', 'address', 'building']);
        if ($request->hasFile('img_path')) {
            $oldImage = $profile->img_path;
            $profileData['img_path'] = $request->file('img_path')->store('profiles', 'public');

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }
        $profile->update($profileData);
        return redirect()->route('mypage');
    }


}
