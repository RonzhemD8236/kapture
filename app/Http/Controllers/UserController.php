<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'role'      => 'required|in:customer,admin',
            'is_active' => 'required|in:0,1',
        ]);

        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'is_active'  => $request->input('is_active'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return redirect()->route('admin.users')
                ->with('error', 'User not found.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'role'      => 'required|in:customer,admin',
            'is_active' => 'required|in:0,1',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'is_active'  => $request->input('is_active'),
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user active/inactive status
     */
    public function toggleStatus($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return redirect()->route('admin.users')
                ->with('error', 'User not found.');
        }

        DB::table('users')->where('id', $id)->update([
            'is_active'  => !$user->is_active,
            'updated_at' => now(),
        ]);

        $status = !$user->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.users')
            ->with('success', "User {$status} successfully.");
    }

    /**
     * Update role only
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:customer,admin',
        ]);

        DB::table('users')->where('id', $id)->update([
            'role'       => $request->role,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User role updated successfully.');
    }
}