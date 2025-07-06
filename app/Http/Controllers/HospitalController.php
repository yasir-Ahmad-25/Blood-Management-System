<?php

namespace App\Http\Controllers;

use App\Models\Hospitals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    public function hospitalDashboard(){
        $data = [
            'title' => 'Hospital Admin Page', 
            'hospital_name' => 'XYZ'
        ];

        return view('hospital.dashboard',$data);
    }

    public function hospitalLogin(){
        return view('hospital.login');
    }

    public function hospitalAuthenticate(Request $request){

        $username = $request->input('username');
        $password = $request->input('password');

        $hospital = Hospitals::where('username', $username)->first();

        if($hospital){
            $hashedPassword = (string) $hospital->password;
            // check password
            if(password_verify($password,$hashedPassword)){
                Auth::guard('hospital')->login($hospital);
                session()->regenerate();
                session()->regenerateToken();
                return redirect()->route('hospital.dashboard')->with('success', 'Logged in successfully');
            }else{
                return redirect()->back()->with('error', 'Username or password is incorrect');
            }
        }else{
            return redirect()->back()->with('error', 'Username or password is incorrect');
        }


    }

    public function hospitalLogout(){
        Auth::guard('hospital')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('hospital.login');
    }
}
