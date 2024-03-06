<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('Users/register');
    }

    public function showLoginPage()
    {
        return view('Users/login');
    }

    public function register(Request $request)
    {
        // Validate the user input
    $request->validate([
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'plate_number' => 'required|unique:users',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Remove 'required'
    ]);

    $imageName = 'user_photo.png'; // Default image name

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName(); // Use the original file name
        $image->move(public_path('profiles'), $imageName);
    }

    // Create the user
    $user = new User();
    $user->username = $request->username;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->plate_number = $request->plate_number;
    $user->image = $imageName;
    $user->save();

    // Redirect the user after successful registration
    return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    public function login(Request $request)
    {
        // Validate the user input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/home'); // Redirect to the intended URL or a default path
        }

        // Authentication failed
        return back()->withErrors(['error' => 'Invalid credentials']); // Redirect back with an error message
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showuserprofile()
    {
        return view('Users/userprofile');
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|min:6',
            'plate_number' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the user uploaded image
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName); // Moving file to public/images
            $user->image = $imageName;
        }

        // update passowrd
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->plate_number = $validatedData['plate_number'];

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function deactivate()
    {
        $user = Auth::user();
        $user->type = 'irregular';
        $user->save();

        return back()->with('success', 'Account deactivated successfully.');
    }


}
