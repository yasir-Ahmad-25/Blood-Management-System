<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
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

    // =========================  LOGIN & LOGOUT SECTION ============================
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


    // ==========================  Request Section =======================
    public function BloodRequests(){

        $bloodRequests = BloodRequest::all();
        $data = [
            'title' => 'Request Blood',
            'bloodRequests' => $bloodRequests,
        ];
        return view('hospital.BloodRequests', $data);
    }

    public function create_BloodRequest(){

        $data = [
            'title' => 'Blood Request'
        ];
        return view('hospital.create_BloodRequest', $data);
    }

    public function record_Bloodrequest(Request $request){
        
        // validate the request
        $request->validate([
            'blood_type' => 'required|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'qty' => 'required',
        ]);



        $BloodrequestData = [
            'hospital_id' => Auth::guard('hospital')->id(),
            'blood_type' => $request->input('blood_type'),
            'qty' => $request->input('qty'),
            'status' => "Pending",
            'requested_date' => date('Y-m-d')
        ];

        $sendRequest = BloodRequest::create($BloodrequestData);
         if( !$sendRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to Send Blood Request Please Try Again.....'
            ], 500);
        }

        
        return response()->json([
            'status' => true,
            'message' => 'Request Sent successfully',
        ]);

    }

    public function cancel_request($id){
        // check if the request exist
        $requestedBlood = BloodRequest::where('request_id', $id)->first();

        if($requestedBlood){
            BloodRequest::where('request_id', $id)->delete();
             return response()->json([
                'success' => true,
                'message' => 'Request Canceled successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed To Cancel Request Please Try Again Later.....',
        ]);
    }
}
