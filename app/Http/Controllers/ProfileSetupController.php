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
        $customer = DB::table('customer')->where('id', Auth::id())->first();
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
            'id'          => Auth::id(),
            'user_id'     => Auth::id(),
            'fname'       => $request->fname,
            'lname'       => $request->lname,
            'title'       => $request->title ?? '',
            'addressline' => $request->addressline,
            'town'        => $request->town,
            'phone'       => $request->phone,
            'zipcode'     => $request->zipcode,
        ]);

        // Update users table with photo and full name
        DB::table('users')->where('id', Auth::id())->update([
            'profile_photo' => $photoPath,
            'name'          => $request->fname . ' ' . $request->lname,
        ]);

        return redirect()->route('home')->with('success', 'Welcome to Kapture! Your profile is set up.');
    }
}