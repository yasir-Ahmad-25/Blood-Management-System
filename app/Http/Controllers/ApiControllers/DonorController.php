<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;

use App\Models\BloodDonations;
use App\Models\Donors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class DonorController extends Controller
{
    public function register(Request $request)
    {
        // Validate fields
        $validator = Validator::make($request->all(), [
            'fullname'      => 'required|string|max:100',
            'email'         => 'required|email|unique:donors,email',
            'phone'         => 'required|string|max:30',
            'date_of_birth' => 'required|date',
            'address'       => 'required|string|max:255',
            'sex'           => 'required|in:Male,Female',
            'blood_type'    => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'password'      => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation error'
            ], 422);
        }

        // Create donor
        $donor = Donors::create([
            'fullname'      => $request->fullname,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'address'       => $request->address,
            'sex'           => $request->sex,
            'blood_type'    => $request->blood_type,
            'password'      => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully!',
            'donor'   => $donor
        ]);
    }

    public function Login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = Donors::where('email', $email)->first();

        $totalDonations = BloodDonations::where('donor_id', $user->id)->count();

        if (!$user) {
            // User not found
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 404);
        }

        if (!password_verify($password, $user->password)) {
            // Wrong password
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        // Optionally, generate token for mobile app authentication
        // $token = $user->createToken('donor_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully.',
            'user' => [
                'id' => $user->id,
                'fullname' => $user->fullname,
                'email' => $user->email,
                'blood_type' => $user->blood_type,
                'phone' => $user->phone,
                'date_of_birth' => $user->date_of_birth,
                'address' => $user->address,
                'sex' => $user->sex,
                // Add these if you have them:
                'member_since' => $user->created_at ? $user->created_at->format('Y') : '',
                'total_donations' => $totalDonations ?? 0,
                'last_donation_date' => $user->last_donation_date ?? '',
            ],
        ]);

    }

    // fetching donors
    public function index(Request $request)
    {
        $query = Donors::query();
        // Exclude the currently logged-in user
        if ($request->has('exclude_id')) {
            $query->where('id', '!=', $request->exclude_id);
        }

        // Optional: filter by blood_type
        if ($request->has('blood_type') && $request->blood_type != 'All') {
            $query->where('blood_type', $request->blood_type);
        }
        // Optional: search
        if ($request->has('search')) {
            $query->where('fullname', 'like', '%' . $request->search . '%');
        }
        $donors = $query->select('id', 'fullname', 'blood_type', 'email', 'date_of_birth', 'last_donation_date')->orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'donors' => $donors,
        ]);
    }

    // update donor data
    public function update(Request $request, $id)
    {
        $donor = Donors::findOrFail($id);
        $donor->fullname = $request->fullname;
        // $donor->age = $request->age;
        $donor->phone = $request->phone;
        $donor->address = $request->address;
        $donor->save();

        return response()->json(['success' => true, 'message' => 'Profile updated']);
    }


}
