<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends Controller
{

    public function index()
    {
    
    }

    public function create()
    {
        return view('users.profile');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:4',
            'lname' => 'required|min:4',
            'addressline' => 'required|min:4',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $item = Customer::create([
            'title' => trim($request->title),
            'fname' => $request->fname,
            'lname' => $request->lname,
            'addressline' => $request->addressline,
            'town' => $request->town,
            'zipcode' => $request->zipcode,
            'phone' => $request->phone,
            'user_id' => Auth::id()

        ]);

        return redirect('/')->with('success', 'profile created');
    }

    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
      
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
