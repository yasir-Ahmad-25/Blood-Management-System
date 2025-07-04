<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(){
        $data = [
            'title' => 'Admin Login',
        ];

        return view('admin.login', $data);
    }

    public function authenticate(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        // check if email exist
        $userData = User::where('email', $email)->first();
        if($userData){
            $hashedpassword = (string) $userData->password;
            // check if password is valid
            if(password_verify($password, $hashedpassword)){
                Auth::login($userData);
                session()->regenerate();
                session()->regenerateToken();
                return redirect()->route('admin.index')->with('success', 'Logged in successfully');
            }else{
                return redirect()->back()->with('error', 'Username or password is incorrect');
            }
        }else{
            return redirect()->back()->with('error', 'Username or password is incorrect');
        }
        

    }
}
