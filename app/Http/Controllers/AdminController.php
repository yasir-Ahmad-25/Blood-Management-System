<?php

namespace App\Http\Controllers;

use App\Models\BloodDonations;
use App\Models\BloodInventory;
use App\Models\Donors;
use App\Models\Hospitals;
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
            'email' => $request->input('Email'),
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
            'email' => $request->input('Email'),
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
            return redirect()->back()->with('error', 'Failed to Delete donor');
        }

        return redirect()->back()->with('success', 'Donor deleted successfully');
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
            $bloodInventoryData = [
                'blood_type' => $donation->blood_type,
                'volume' => $donation->volume_ml / 1000, // Convert ml to liters
                'donor_id' => $donation->donor_id,
                'collection_date' => $donation->donation_date,
                'expiration_date' => now()->addDays(42), // Assuming blood expires in 42 days
                'status' => 'available',
            ];
            BloodInventory::create($bloodInventoryData);
        }
        if (!$donation->save()) {
            return redirect()->back()->with('error', 'Failed to update donation status');
        }
        return redirect()->back()->with('success', 'Donation status updated successfully');
    }


    // Blood Inventory Management
    public function bloodInventories(){
        $bloodInventories = BloodInventory::join('donors', 'blood_inventories.donor_id', '=', 'donors.id')
            ->select('blood_inventories.*', 'donors.fullname as donor_fullname')
            ->orderBy('blood_inventories.blood_id', 'desc')
            ->get();

        // Inventory summary (count by blood type)
        $bloodSummary = BloodInventory::where('status', 'available')
            ->select('blood_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('blood_type')
            ->pluck('count', 'blood_type');

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
            'contact_person' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
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
}
