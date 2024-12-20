<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Models\Utility;
use Illuminate\Auth\Events\PasswordReset;
use Mail;
use App\Mail\TestMail;
use App\Mail\OTPMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends BaseController
{
     //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Maintenance::all(), 200);
    }

    // Store a new property owner
    public function store(Request $request)
    {
        // print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'ticket_no' => 'required|string|max:255',
            'property' => 'required|string|max:255',
            'unit' => 'required',
            'issue_type' => 'required',
            'maintainer' => 'required|string|max:20',
            'description' => 'required|string',
            'images' => 'required'         
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


       
        $maintenance = Maintenance::create([
            'ticket_no' => $request->ticket_no,
            'property' => $request->property,
            'unit' => $request->unit,
            'issue_type' => $request->issue_type,
            'maintainer' => $request->maintainer,
            'description' => $request->description,
        ]);


        $path = $request->file('images')->store('images', 'public');
        $maintenance->images = $path;
        $maintenance->save();

        $data[] = [
            'maintenance'=>$maintenance,
            'profile_picture'=>Storage::url($maintenance->images),
            'status'=>200,
          ];

        return response()->json($data, 201);
    }



    // Show a single property owner
    public function show($id)
    {
        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance not found'], 404);
        }
        return response()->json($maintenance, 200);
    }

    // Update a property owner
    public function update($id, Request $request)
    {
        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'ticket_no' => 'required|string|max:255',
            'property' => 'required|string|max:255',
            'unit' => 'required',
            'issue_type' => 'required|string|max:20',
            'maintainer' => 'required|string|max:20',
            'description' => 'required|string',
            'images' => 'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
            


        $maintenance->update(['ticket_no' => $request->ticket_no,
            'property' => $request->property,
            'unit' => $request->unit,
            'issue_type' => $request->issue_type,
            'maintainer' => $request->maintainer,
            'description' => $request->description,
        ]);
        return response()->json($maintenance, 200);

    }

  

    // Delete a property owner
    public function destroy($id)
    {
        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json(['message' => 'maintenance not found'], 404);
        }

        $maintenance->delete();
        return response()->json(['message' => 'maintenance deleted successfully'], 200);
    }

    public function updateStatus($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
           
            $maintenance = Maintenance::find($id);
            if (!$maintenance) {
                return response()->json(['error' => 'maintenance not found'], 404);
            }

            $maintenance->update(['status' => $request->status]);
            return $this->sendResponse($maintenance, 'maintenance status updated successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }

    public function assignOwner($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assign_package' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $maintenance = Maintenance::find($id);
            if (!$maintenance) {
                return response()->json(['error' => 'maintenance not found'], 404);
            }
            $maintenance->update(['assign_package' => $request->assign_package]);
            // $user = User::create([
            //     'name' => $maintenance->full_name,
            //     'email' => $maintenance->email_address,
            //     'password' => $maintenance->password,
            //     'role_id' => '2',
            //     'address' => $maintenance->address,
            //     'phone_number' => $maintenance->contact_number,
            //     'owner_id'=>$id
            // ]);
           

            return $this->sendResponse($owner, 'Owner approved updated successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
