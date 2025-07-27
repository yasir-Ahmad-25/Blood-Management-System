<?php

namespace App\Http\Controllers;

use App\Models\BloodDonations;
use App\Models\BloodInventory;
use App\Models\BloodRequest;
use App\Models\Donors;
use App\Models\HospitalInventory;
use App\Models\Hospitals;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index(){
        
            // Gather data for cards
            $total_donors = Donors::count();
            $total_hospitals = Hospitals::count();
            $total_blood_units = BloodInventory::sum('volume');
            $total_requests = BloodRequest::count();

            // Recent activities (combine requests, donations, etc.)
            $recent_activities = collect([
                // Example data, adapt as needed
                [
                    'date' => now()->format('Y-m-d'),
                    'type' => 'Donation',
                    'type_color' => 'danger',
                    'details' => 'John Doe donated 1 unit of O+'
                ],
                [
                    'date' => now()->format('Y-m-d'),
                    'type' => 'Request',
                    'type_color' => 'primary',
                    'details' => 'Hospital XYZ requested 2 units of A-'
                ],
                // ...
            ])->take(5);

            $data = [
                'title' => 'Admin Dashboard',
                'total_donors' => $total_donors,
                'total_hospitals' => $total_hospitals,
                'total_blood_units' => $total_blood_units,
                'total_requests' => $total_requests,
                'recent_activities' => $recent_activities,
            ];

            return view('admin.index', $data);
    }

    public function logout(){
        Auth::logout();
        session()->regenerate();
        session()->regenerateToken();
        session()->invalidate();
        return redirect()->route('auth.login');
    }


    // Donors
    public function donors(){
        $donors = Donors::orderBy('id', 'desc')->paginate(10);
        $data = [
            'title' => 'Donors List',
            'donors' => $donors,
        ];

        return view('admin.donors', $data);
    }

    // create a new donor
    public function createDonor(){
        
        $data = [
            'title' => 'Create New Donor',
        ];

        return view('admin.create_donor', $data);
    }

    // record Donor Data to the database
    public function recordDonor(Request $request){

        // validate the request
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:donors,email',
            'phone' => 'required|string|max:15|unique:donors,phone',
            'blood_type' => 'required|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'sex' => 'required|string|in:Male,Female,other'
        ]);

        // check if validation passes
        $donorData = [
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'sex' => $request->input('sex'),
            'date_of_birth' => $request->input('date_of_birth'),
            'blood_type' => $request->input('blood_type'),
            'address' => $request->input('address'),
        ];

        // Here you would typically save the donor to the database
        $saveDonor = Donors::create($donorData);
        if( !$saveDonor) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create donor'
            ], 500);
        }

        // For now, we will just return a success message
        return response()->json([
            'status' => true,
            'message' => 'Donor created successfully',
            'donor' => $donorData
        ]);
    }

    public function editDonor($id){
        $donor = Donors::findOrFail($id);
        $data = [
            'title' => 'Edit Donor',
            'donor' => $donor,
        ];

        return view('admin.edit_donor', $data);
    }

    public function updateDonor(Request $request, $id){
        // validate the request
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:donors,email,'.$id,
            'phone' => 'required|string|max:15|unique:donors,phone,'.$id,
            'blood_type' => 'required|string|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'sex' => 'required|string|in:Male,Female,other',
        ]);

        // check if validation passes
        $donorData = [
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'sex' => $request->input('sex'),
            'date_of_birth' => $request->input('date_of_birth'),
            'blood_type' => $request->input('blood_type'),
            'address' => $request->input('address'),
        ];
        // Find the donor by ID and update
        $donor = Donors::findOrFail($id);
        $updateDonor = $donor->update($donorData);
        if( !$updateDonor) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update donor'
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Donor updated successfully',
            'donor' => $donorData
        ]);
    }

    public function deleteDonor($id){
        // Find the donor by ID and delete
        $donor = Donors::findOrFail($id);
        $deleteDonor = $donor->delete();
        if( !$deleteDonor) {
            return response()->json([
                'success' => false, 
                'message' => "Failed to Delete donor"
            ]);
        }
        
        return response()->json([
            'success' => true, 
            'message' => "Donor deleted successfully"
        ]);
    }

    public function getDonorBloodType(Request $request){
        $donorId = $request->input('donorId');
        $donor = Donors::find($donorId);
        if (!$donor) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, Donor not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'blood_type' => $donor->blood_type
        ]);
    }

    // Donation Management

    public function donations(){
        $donations = BloodDonations::join('donors', 'blood_donations.donor_id', '=', 'donors.id')
            ->select('blood_donations.*', 'donors.fullname as donor_fullname', 'donors.blood_type as donor_blood_type')
            ->orderBy('blood_donations.id', 'desc')
            ->paginate(10);
        $data = [
            'title' => 'Donations List',
            'donations' => $donations,
        ];

        return view('admin.donations', $data);
    }

    public function createDonation(){
        $donors = Donors::orderBy('id', 'desc')->get();
        $data = [
            'title' => 'Create Donation',
            'donors' => $donors,
        ];
        return view('admin.create_donation', $data);    
    }

    public function recordDonation(Request $request){
        // validate the request
        $request->validate([
            'donor' => 'required|exists:donors,id',
            'volume' => 'required|numeric|min:1',
            'donation_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        // check if validation passes
        $donationData = [
            'donor_id' => $request->input('donor'),
            'volume_ml' => $request->input('volume'),
            'donation_date' => $request->input('donation_date'),
            'blood_type' => $request->input('blood_type'),
            'location' => $request->input('location'),
            'remarks' => $request->input('remarks', ''),
        ];

        // Here you would typically save the donation to the database

        $saveDonation = BloodDonations::create($donationData);
        if( !$saveDonation) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create donation'
            ], 500);
        }
        
        // For now, we will just return a success message
        return response()->json([
            'status' => true,
            'message' => 'Donation created successfully',
            'donation' => $donationData
        ]);
    }

    public function change_donation_status($id,$action){
        $donation = BloodDonations::findOrFail($id);
        $status = $donation->status;

        if ($status === 'collected' && $action === 'start_testing') {
            $donation->status = 'in_testing';
        } elseif ($status === 'in_testing') {
            if ($action === 'approve') {
                $donation->status = 'approved';
            } elseif ($action === 'reject') {
                $donation->status = 'rejected';
            }
        }


        $donation->where('id', $id)->update(['status' => $donation->status]);
        // record blood inventory
        if ($donation->status === 'approved') {
            // Try to find an existing inventory row for this blood type and available status
            $existingInventory = BloodInventory::where('blood_type', $donation->blood_type)
                ->where('status', 'available')
                ->first();

            if ($existingInventory) {
                // If found, increment the volume/qty
                $existingInventory->volume += $donation->volume_ml;
                $existingInventory->save();
            } else {
                // Otherwise, insert new inventory row
                $bloodInventoryData = [
                    'blood_type' => $donation->blood_type,
                    'volume' => $donation->volume_ml,
                    'donor_id' => $donation->donor_id,
                    'collection_date' => $donation->donation_date,
                    'expiration_date' => now()->addDays(42), // Usually 42 days for whole blood
                    'status' => 'available',
                ];
                BloodInventory::create($bloodInventoryData);
            }
        }
        return redirect()->back()->with('success', 'Donation status updated successfully');
    }


    // Blood Inventory Management
    public function bloodInventories(){
        $bloodInventories = BloodInventory::join('donors', 'blood_inventories.donor_id', '=', 'donors.id')
            ->select('blood_inventories.*', 'donors.fullname as donor_fullname')
            ->orderBy('blood_inventories.blood_id', 'desc')
            ->paginate(10);

        // Inventory summary (count by blood type)
        $bloodSummary = BloodInventory::where('status', 'available')
            ->select('blood_type', DB::raw('SUM(volume) as total_volume'))
            ->groupBy('blood_type')
            ->pluck('total_volume', 'blood_type');

        $data = [
            'title' => 'Blood Inventories',
            'bloodInventories' => $bloodInventories,
            'bloodSummary' => $bloodSummary,
        ];
        return view('admin.blood_inventories', $data);
    }


    // Hospital Management
    public function hospitals(){
        $hospitals = Hospitals::orderBy('id', 'desc')->paginate(10);
        $data = [
            'title' => 'Hospitals List',
            'hospitals' => $hospitals,
        ];
        return view('admin.hospitals', $data); 
    }

    public function createHospital(){
        $data = [
            'title' => 'Create New Hospital',
        ];
        return view('admin.create_hospital', $data);
    }

    public function recordHospital(Request $request){
        // validate the request
        $request->validate([
            'hospital_name' => 'required|string|max:255|unique:hospitals,username',
            'hospital_email' => 'nullable|email|max:255|unique:hospitals,email',
            'hospital_phone' => 'nullable|string|max:15|unique:hospitals,phone',
            'hospital_Address' => 'required|string|max:255',
            // 'contact_person' => 'nullable|string|max:255',
            // 'region' => 'nullable|string|max:255',
            'hospital_password' => 'nullable|string|min:4', // Optional password, default will be set if not provided
        ]);

        // check if validation passes
        $hospitalData = [
            'name' => $request->input('hospital_name'),
            'email' => $request->input('hospital_email'),
            'phone' => $request->input('hospital_phone'),
            'address' => $request->input('hospital_Address'),
            'contact_person' => $request->input('contact_person'),
            'region' => $request->input('hospital_region'),
            'status' => 'active', // default to active if not provided
            'username' => $request->input('hospital_username'), // Assuming username is same as hospital name
            'password' => bcrypt($request->input('hospital_password')), // Default password if not provided
        ];

        // Here you would typically save the hospital to the database
        $saveHospital = Hospitals::create($hospitalData);
        if( !$saveHospital) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create Hospital'
            ], 500);
        }

        // For now, we will just return a success message
        return response()->json([
            'status' => true,
            'message' => 'Hospital created successfully',
            'hospital' => $hospitalData
        ]);
    }

    public function editHospital($id){
        $hospital = Hospitals::findOrFail($id);
        $data = [
            'title' => 'Edit Hospital',
            'hospital' => $hospital,
        ];

        return view('admin.edit_hospital', $data);
    }

    public function updateHospital(Request $request,$id){
        
        // validate the request
        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'hospital_email' => 'nullable|email|max:255',
            'hospital_phone' => 'nullable|string|max:15',
            'hospital_Address' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'hospital_password' => 'nullable|string|min:4', 
        ]);


        // check if validation passes
        $hospitalData = [
            'name' => $request->input('hospital_name'),
            'email' => $request->input('hospital_email'),
            'phone' => $request->input('hospital_phone'),
            'address' => $request->input('hospital_Address'),
            'contact_person' => $request->input('contact_person'),
            'region' => $request->input('hospital_region'),
            'status' => 'active', // default to active if not provided
            'username' => $request->input('hospital_username'), // Assuming username is same as hospital name
            'password' => bcrypt($request->input('hospital_password')), // Default password if not provided
        ];


        $updateHospital = Hospitals::where('id',$id)->update($hospitalData);

        if(!$updateHospital){
            return response()->json([
                'status' => false, 
                'message' => "Failed To Update Hospital Data"
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Hospital Has Been Updated Successfully"
        ]);

    }

    public function deleteHospital($id){
        $hospital = Hospitals::findOrFail($id);
        $hospital->delete();

        return response()->json([
            'success' => true,
            'message' => "Hospital Has Been Deleted"
        ]);
        // return redirect()->back()->with('success','Hospital Deleted Successfully');
    }


    // Requests Management
    public function requests_blood(){

        $blood_requests = BloodRequest::join('hospitals','tbl_blood_requests.hospital_id','=','hospitals.id')
                                        ->select('tbl_blood_requests.*','hospitals.name as Hospital_Name')
                                        ->orderBy('tbl_blood_requests.request_id','desc')
                                        ->get();

        // Count requests per blood type
        $allTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $bloodRequestCounts = BloodRequest::select('blood_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('blood_type')
            ->pluck('count', 'blood_type')
            ->toArray();

        // Ensure all types are shown (even if 0)
        $bloodRequestCards = [];
        foreach($allTypes as $type) {
            $bloodRequestCards[$type] = $bloodRequestCounts[$type] ?? 0;
        }

        $data = [
            'title' => 'Blood Requests',
            'blood_requests' => $blood_requests,
            'bloodRequestCards' => $bloodRequestCards,
        ];
        return view('admin.requests_blood', $data);
    }

    public function accept_request($id)
    {
        // Start transaction for data consistency
        DB::beginTransaction();

        try {
            // 1. Find the request
            $bloodRequest = BloodRequest::where('request_id', $id)->firstOrFail();
            if($bloodRequest->status !== 'Pending') {
                return response()->json(['success' => false, 'message' => 'Request already processed.']);
            }

            // 2. Deduct from admin inventory
            $centralInventory = BloodInventory::where('blood_type', $bloodRequest->blood_type)
                ->where('status', 'available')
                ->first();

            if(!$centralInventory || $centralInventory->volume < $bloodRequest->qty) {
                return response()->json(['success' => false, 'message' => 'Insufficient blood units in inventory!']);
            }

            $centralInventory->volume -= $bloodRequest->qty;
            $centralInventory->save();

            // 3. Increment in hospital inventory
            $hospitalInventory = HospitalInventory::where('hospital_id', $bloodRequest->hospital_id)
                ->where('blood_type', $bloodRequest->blood_type)
                ->first();

            if($hospitalInventory) {
                $hospitalInventory->qty += $bloodRequest->qty;
                $hospitalInventory->status = 'available';
                $hospitalInventory->save();
            } else {
                HospitalInventory::create([
                    'hospital_id' => $bloodRequest->hospital_id,
                    'blood_type' => $bloodRequest->blood_type,
                    'qty' => $bloodRequest->qty,
                    'status' => 'available',
                ]);
            }

            // 4. Update request status
            BloodRequest::where('request_id', $id)->update(['status' => 'Accepted']);


            DB::commit();

            return response()->json(['success' => true, 'message' => 'Request accepted and processed successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to process request: ' . $e->getMessage()]);
        }
    }

    public function cancel_request($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);

        if($bloodRequest->status !== 'Pending') {
            return response()->json(['success' => false, 'message' => 'Request already processed.']);
        }

        $bloodRequest->status = 'Declined';
        $bloodRequest->save();

        return response()->json(['success' => true, 'message' => 'Request declined successfully.']);
    }

    // Report


    public function report()
    {
        // Summary stats
        $totalDonors = Donors::count();
        $totalDonations = BloodDonations::count();
        $totalHospitals = Hospitals::count();
        $totalRequests = BloodRequest::count();
        $inventoryUnits = BloodInventory::where('status', 'available')->count();

        // Recent Donations (last 5)
        $recentDonations = BloodDonations::join('donors', 'blood_donations.donor_id', '=', 'donors.id')
            ->orderByDesc('donation_date')
            ->take(5)
            ->get();

        // Recent Requests (last 5)
        $recentRequests = BloodRequest::join('hospitals', 'tbl_blood_requests.hospital_id', '=', 'hospitals.id')
            ->orderByDesc('requested_date')
            ->take(5)
            ->get();

        // Blood type summary for low stock alert
        $bloodSummary = BloodInventory::where('status', 'available')
            ->select('blood_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('blood_type')
            ->pluck('count', 'blood_type');

        return view('admin.report', [
            'title' => 'Reports',
            'totalDonors' => $totalDonors,
            'totalDonations' => $totalDonations,
            'totalHospitals' => $totalHospitals,
            'totalRequests' => $totalRequests,
            'inventoryUnits' => $inventoryUnits,
            'recentDonations' => $recentDonations,
            'recentRequests' => $recentRequests,
            'bloodSummary' => $bloodSummary,
        ]);
    }



    // FORGOT PASSWORD SECTION
    public function showForgotPasswordForm()
    {
        return view('admin.forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Only for admins
        $response = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

    public function showResetPasswordForm($token)
    {
        $email = request('email'); // This gets the email from the link (?email=...)
        return view('admin.reset_password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $response = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('status', 'Password reset successfully!')
            : back()->withErrors(['email' => [__($response)]]);
    }
    

}
