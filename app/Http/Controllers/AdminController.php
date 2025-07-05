<?php

namespace App\Http\Controllers;

use App\Models\BloodDonations;
use App\Models\Donors;
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
}
