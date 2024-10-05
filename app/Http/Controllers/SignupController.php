<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usermlm;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function create()
    {
        return view('signup');
    }

    public function signin()
    {
        return view('signin');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'mobile' => 'required|string|min:10|max:15',
        ]);

        // Create a new user
        Usermlm::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,//Hash::make($request->password),
            'mobile' => $request->mobile,
        ]);

        return redirect()->route('signup.create')->with('success', 'Signup successful!');
    }
}
