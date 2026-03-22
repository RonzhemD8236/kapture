<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileSetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        // If profile already completed, go to home
        $customer = DB::table('customer')->where('user_id', Auth::id())->first();
        if ($customer) {
            return redirect()->route('home');
        }
        return view('users.profile-setup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname'         => ['required', 'string', 'max:100'],
            'lname'         => ['required', 'string', 'max:100'],
            'title'         => ['nullable', 'string', 'max:50'],
            'addressline'   => ['required', 'string', 'max:255'],
            'town'          => ['required', 'string', 'max:100'],
            'phone'         => ['required', 'string', 'max:20'],
            'zipcode'       => ['required', 'string', 'max:10'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Handle photo upload
        $photoPath = 'default.jpg';
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Save to customer table
        DB::table('customer')->insert([
            'user_id'     => Auth::id(),
            'fname'       => $request->fname,
            'lname'       => $request->lname,
            'title'       => $request->title ?? '',
            'addressline' => $request->addressline,
            'town'        => $request->town,
            'phone'       => $request->phone,
            'zipcode'     => $request->zipcode,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Update users table with photo and full name
        DB::table('users')->where('id', Auth::id())->update([
            'profile_photo' => $photoPath,
            'name'          => $request->fname . ' ' . $request->lname,
        ]);

        return redirect()->route('home')->with('success', 'Welcome to Kapture! Your profile is set up.');
    }

    public function edit()
    {
        $user     = DB::table('users')->where('id', Auth::id())->first();
        $customer = DB::table('customer')->where('user_id', Auth::id())->first();
        return view('users.profile-edit', compact('user', 'customer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'fname'         => ['required', 'string', 'max:100'],
            'lname'         => ['required', 'string', 'max:100'],
            'title'         => ['nullable', 'string', 'max:50'],
            'addressline'   => ['required', 'string', 'max:255'],
            'town'          => ['required', 'string', 'max:100'],
            'phone'         => ['required', 'string', 'max:20'],
            'zipcode'       => ['required', 'string', 'max:10'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Handle photo upload
        $user = DB::table('users')->where('id', Auth::id())->first();
        $photoPath = $user->profile_photo ?? 'default.jpg';

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if not default
            if ($photoPath && $photoPath !== 'default.jpg') {
                \Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Update customer table
        $customer = DB::table('customer')->where('user_id', Auth::id())->first();
        if ($customer) {
            DB::table('customer')->where('user_id', Auth::id())->update([
                'fname'       => $request->fname,
                'lname'       => $request->lname,
                'title'       => $request->title ?? '',
                'addressline' => $request->addressline,
                'town'        => $request->town,
                'phone'       => $request->phone,
                'zipcode'     => $request->zipcode,
            ]);
        } else {
            DB::table('customer')->insert([
                'user_id'     => Auth::id(),
                'fname'       => $request->fname,
                'lname'       => $request->lname,
                'title'       => $request->title ?? '',
                'addressline' => $request->addressline,
                'town'        => $request->town,
                'phone'       => $request->phone,
                'zipcode'     => $request->zipcode,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // Update users table
        DB::table('users')->where('id', Auth::id())->update([
            'profile_photo' => $photoPath,
            'name'          => $request->fname . ' ' . $request->lname,
        ]);

        return redirect()->route('customer.profile.edit')->with('success', 'Profile updated successfully.');
    }
}