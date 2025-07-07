<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\HospitalInventory;
use App\Models\HospitalInventoryStockOut;
use App\Models\Hospitals;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    public function hospitalDashboard() {
        $hospital_id = Auth::guard('hospital')->id();
        $hospital_data = Hospitals::find($hospital_id);

        // Query for cards
        $total_requests = BloodRequest::where('hospital_id', $hospital_id)->count();
        $pending_requests = BloodRequest::where('hospital_id', $hospital_id)->where('status', 'Pending')->count();
        $accepted_requests = BloodRequest::where('hospital_id', $hospital_id)->where('status', 'Accepted')->count();
        $declined_requests = BloodRequest::where('hospital_id', $hospital_id)->where('status', 'Declined')->count();

        // Inventory summary by type
        $inventory_summary = HospitalInventory::where('hospital_id', $hospital_id)
            ->pluck('qty', 'blood_type')->toArray();

        // Recent activities (combine requests/stockouts for example)
        $recent_requests = BloodRequest::where('hospital_id', $hospital_id)
            ->orderBy('requested_date', 'desc')->take(3)->get()
            ->map(fn($r) => "Requested {$r->qty} units of {$r->blood_type} on {$r->requested_date} ({$r->status})")->toArray();

        $recent_stockouts = HospitalInventoryStockOut::where('hospital_id', $hospital_id)
            ->orderBy('created_at', 'desc')->take(2)->get()
            ->map(fn($s) => "Stockout: {$s->qty} units of {$s->blood_type} reported")->toArray();

        $recent_activities = array_merge($recent_requests, $recent_stockouts);

        $data = [
            'title' => 'Hospital Admin Page',
            'hospital' => $hospital_data,
            'total_requests' => $total_requests,
            'pending_requests' => $pending_requests,
            'accepted_requests' => $accepted_requests,
            'declined_requests' => $declined_requests,
            'inventory_summary' => $inventory_summary,
            'recent_activities' => $recent_activities,
        ];

        return view('hospital.dashboard', $data);
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
    public function BloodRequests() {
        $hospital_id = Auth::guard('hospital')->id();

        // List of all possible blood types
        $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        // Get inventory grouped by blood type for this hospital
        $stock = HospitalInventory::where('hospital_id', $hospital_id)
            ->pluck('qty', 'blood_type')->toArray();

        // Fill in missing types with zero
        $blood_stock = [];
        foreach ($blood_types as $type) {
            $blood_stock[$type] = isset($stock[$type]) ? $stock[$type] : 0;
        }

        $bloodRequests = BloodRequest::where('hospital_id', $hospital_id)
            ->orderBy('requested_date', 'desc')->get();

        $data = [
            'title' => 'Request Blood',
            'bloodRequests' => $bloodRequests,
            'blood_stock' => $blood_stock,
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

    public function stockout(){

        $hospital_id = Auth::guard('hospital')->id();
        $blood_types_stock = HospitalInventory::where('hospital_id',$hospital_id)->get();

        $recent_stockouts = HospitalInventoryStockOut::where('hospital_id', $hospital_id)
            ->orderByDesc('created_at')->take(6)->get();
        $data = [
            'title' => 'Stock List',
            'blood_types_stock' => $blood_types_stock,
            'recent_stockouts' => $recent_stockouts,
            ];

        return view('hospital.stockout',$data);
    }

    public function create_stockout(){
            $hospital_id = Auth::guard('hospital')->id();
            $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            $stock = HospitalInventory::where('hospital_id', $hospital_id)
                ->pluck('qty', 'blood_type')->toArray();

            $blood_stock = [];
            foreach ($blood_types as $type) {
                $blood_stock[$type] = isset($stock[$type]) ? $stock[$type] : 0;
            }

            $data = [
                'title' => 'Stockout',
                'blood_stock' => $blood_stock,
            ];
            return view('hospital.create_stockout', $data);
    }


    public function record_stockout(Request $request)
    {

        DB::beginTransaction();
        try {
            // Validate the request
            $request->validate([
                'blood_type' => 'required|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
                'qty' => 'required|numeric|min:1',
            ]);

            $hospital_id = Auth::guard('hospital')->id();
            $blood_type = $request->input('blood_type');
            $qty = $request->input('qty');
            $stockout_data = [
                'hospital_id' => $hospital_id,
                'blood_type' => $blood_type,
                'qty' => $qty,
            ];

            $saveStockout = HospitalInventoryStockOut::create($stockout_data);
            if(!$saveStockout) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed To Save Stockout'
                ]);
            }

            // Update inventory
            $inventory_data = HospitalInventory::where('hospital_id', $hospital_id)
                ->where('blood_type', $blood_type)
                ->first();

            if(!$inventory_data){
                return response()->json([
                    'success' => false,
                    'message' => 'No inventory found for this blood type.'. $blood_type .' and hospital: ' .$hospital_id
                ]);
            }

            if ($inventory_data->qty < $qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot stockout more units than are available!: '
                ]);
            }
            
            $inventory_data->qty -= $qty;
            $inventory_data->save();
            if ($inventory_data->qty <= 0) {
               $inventory_data->status = 'Out Of Stock';
               $inventory_data->save();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Stockout recorded and inventory updated successfully!'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
           return response()->json(['success' => false, 'message' => 'Failed to make stockout: ' . $e->getMessage()]);
        }
       
    }

}
