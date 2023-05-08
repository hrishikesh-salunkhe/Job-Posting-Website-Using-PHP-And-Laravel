<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    //Display user registration form:
    public function create(){
        return view('users.register');
    }

    //Create new user:
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        //Encrypt password:
        $formFields['password'] = bcrypt($formFields['password']);

        //Create user:
        $user = User::create($formFields);

        //Login:
        auth()->login($user);

        return redirect('/')->with('message', 'User account created and logged in successfully!');
    }

    //Logout user:
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been been logged out successfully!');
    }

    //Display user login form:
    public function login(){
        return view('users.login');
    }

    //Login user:
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You have successfully logged into your account!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
