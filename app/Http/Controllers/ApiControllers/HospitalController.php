<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;

use App\Models\Donors;
use App\Models\Hospitals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospitals::select('id', 'name', 'address')->get();
        return response()->json([
            'success' => true,
            'hospitals' => $hospitals
        ]);
    }

    public function bloodInventory($id)
{
    // List of all blood types
    $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

    // Fetch the hospital's blood inventory (adapt table/model names if needed)
    // This assumes you have a tbl_hospital_inventory with fields: hospital_id, blood_type, qty
    $inventory = \DB::table('tbl_hospital_inventory')
        ->where('hospital_id', $id)
        ->select('blood_type', 'qty')
        ->get();

    // Convert to associative array
    $availability = [];
    foreach ($bloodTypes as $type) {
        // Find qty for each blood type, default to 0
        $record = $inventory->firstWhere('blood_type', $type);
        $availability[$type] = $record ? (int)$record->qty : 0;
    }

    return response()->json(['availability' => $availability]);
}

}
