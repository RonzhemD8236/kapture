<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function show()
    {
        return view('users.admin-profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fname'         => ['required', 'string', 'max:255'],
            'lname'         => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email,' . $user->id],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $photoPath = $user->profile_photo ?? 'default.jpg';

        if ($request->hasFile('profile_photo')) {
            if ($photoPath && $photoPath !== 'default.jpg') {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $data = [
            'fname'         => $request->fname,
            'lname'         => $request->lname,
            'name'          => $request->fname . ' ' . $request->lname,
            'email'         => $request->email,
            'profile_photo' => $photoPath,
            'updated_at'    => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $user->id)->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
}