<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Admin Dashboard',
        ];

        return view('admin.index',$data);
    }

    public function logout(){
        Auth::logout();
        session()->regenerate();
        session()->regenerateToken();
        session()->invalidate();
        return redirect()->route('auth.login');
    }
}
