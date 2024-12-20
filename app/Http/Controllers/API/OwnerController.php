<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
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

class OwnerController extends BaseController
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Owner::all(), 200);
    }

    // Store a new property owner
    public function store(Request $request)
    {
        // print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'owner_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:owners,email_address',
            'password' => 'required|string|min:8|confirmed', 
            'contact_number' => 'required|string|max:20',
            // 'company_name' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date' => 'nullable|string',
            'company_registration_number_uen' => 'required|string',
            // 'gst_number' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'profile_picture' => 'required',
            'verification_document' => 'required',
            'billing_address' => 'required|string',
            'same_as_address' => 'required|string',
            'terms_and_conditions' => 'required|string',
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


       
        $owner = Owner::create([
            'owner_type' => $request->owner_type,
            'full_name' => $request->full_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'date' => $request->date,
            'company_registration_number_uen' => $request->company_registration_number_uen,
            'gst_number' => $request->gst_number,
            'city' => $request->city,
            'state' => $request->state,
            // 'profile_picture' => $request->profile_picture,
            // 'verification_document' => $request->verification_document,
            'billing_address' => $request->billing_address,
            'same_as_address' => $request->same_as_address,
            'terms_and_conditions' => $request->terms_and_conditions,
            // 'assign_package' => $request->assign_package,
        ]);


        $path = $request->file('profile_picture')->store('images', 'public');
        $path_document = $request->file('verification_document')->store('verification_document', 'public');
        $owner->profile_picture = $path;
        $owner->verification_document = $path_document;
        $owner->save();

        $data[] = [
            'owner'=>$owner,
            'profile_picture'=>Storage::url($owner->profile_picture),
            'verification_document'=>Storage::url($owner->verification_document),
            'status'=>200,
          ];

        return response()->json($data, 201);
    }

    public function storeOrganization(Request $request)
    {
        // print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'owner_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:owners,email_address',
            'password' => 'required|string|min:8|confirmed', 
            'contact_number' => 'required|string|max:20',
            'company_name' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date' => 'nullable|string',
            'company_registration_number_uen' => 'required|string',
            'gst_number' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'profile_picture' => 'required',
            'verification_document' => 'required',
            'billing_address' => 'required|string',
            'same_as_address' => 'required|string',
            'terms_and_conditions' => 'required|string',
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       
        $owner = Owner::create([
            'owner_type' => $request->owner_type,
            'full_name' => $request->full_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'date' => $request->date,
            'company_registration_number_uen' => $request->company_registration_number_uen,
            'gst_number' => $request->gst_number,
            'city' => $request->city,
            'state' => $request->state,
            'billing_address' => $request->billing_address,
            'same_as_address' => $request->same_as_address,
            'terms_and_conditions' => $request->terms_and_conditions,
        ]);


        $path = $request->file('profile_picture')->store('images', 'public');
        $path_document = $request->file('verification_document')->store('verification_document', 'public');
        $owner->profile_picture = $path;
        $owner->verification_document = $path_document;
        $owner->save();

        $data[] = [
            'owner'=>$owner,
            'profile_picture'=>Storage::url($owner->profile_picture),
            'verification_document'=>Storage::url($owner->verification_document),
            'status'=>200,
          ];
        return response()->json($data, 201);
    }


    // Show a single property owner
    public function show($id)
    {
        $owner = Owner::find($id);
        if (!$owner) {
            return response()->json(['message' => 'Owner not found'], 404);
        }
        return response()->json($owner, 200);
    }

    // Update a property owner
    public function update($id, Request $request)
    {
        $owner = Owner::find($id);
        if (!$owner) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'owner_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:owners,email_address',
            'password' => 'required|string|min:8|confirmed', 
            'contact_number' => 'required|string|max:20',
            // 'company_name' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date' => 'nullable|string',
            'company_registration_number_uen' => 'required|string',
            // 'gst_number' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'profile_picture' => 'required',
            'verification_document' => 'required',
            'billing_address' => 'required|string',
            'same_as_address' => 'required|string',
            'terms_and_conditions' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
            


        $owner->update(['owner_type' => $request->owner_type,
            'full_name' => $request->full_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'date' => $request->date,
            'company_registration_number_uen' => $request->company_registration_number_uen,
            'gst_number' => $request->gst_number,
            'city' => $request->city,
            'state' => $request->state,
            // 'profile_picture' => $request->profile_picture,
            // 'verification_document' => $request->verification_document,
            'billing_address' => $request->billing_address,
            'same_as_address' => $request->same_as_address,
            'terms_and_conditions' => $request->terms_and_conditions
        ]);
        return response()->json($owner, 200);

    }

    public function updateOrganization($id, Request $request)
    {
        $owner = Owner::find($id);
        if (!$owner) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'owner_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:owners,email_address',
            'password' => 'required|string|min:8|confirmed', 
            'contact_number' => 'required|string|max:20',
            // 'company_name' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date' => 'nullable|string',
            'company_registration_number_uen' => 'required|string',
            // 'gst_number' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'profile_picture' => 'required',
            'verification_document' => 'required',
            'billing_address' => 'required|string',
            'same_as_address' => 'required|string',
            'terms_and_conditions' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
            


        $owner->update(['owner_type' => $request->owner_type,
            'full_name' => $request->full_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'date' => $request->date,
            'company_registration_number_uen' => $request->company_registration_number_uen,
            'gst_number' => $request->gst_number,
            'city' => $request->city,
            'state' => $request->state,
            // 'profile_picture' => $request->profile_picture,
            // 'verification_document' => $request->verification_document,
            'billing_address' => $request->billing_address,
            'same_as_address' => $request->same_as_address,
            'terms_and_conditions' => $request->terms_and_conditions
        ]);
        return response()->json($owner, 200);

    }

    // Delete a property owner
    public function destroy($id)
    {
        $owner = Owner::find($id);
        if (!$owner) {
            return response()->json(['message' => 'Owner not found'], 404);
        }

        $owner->delete();
        return response()->json(['message' => 'Owner deleted successfully'], 200);
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
           
            $owner = Owner::find($id);
            if (!$owner) {
                return response()->json(['error' => 'Owner not found'], 404);
            }

            
            $owner->update(['status' => $request->status]);

           

            return $this->sendResponse($owner, 'Owner status updated successfully.');
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
            $owner = Owner::find($id);
            if (!$owner) {
                return response()->json(['error' => 'Owner not found'], 404);
            }
            $owner->update(['assign_package' => $request->assign_package]);
            $user = User::create([
                'name' => $owner->full_name,
                'email' => $owner->email_address,
                'password' => $owner->password,
                'role_id' => '2',
                'address' => $owner->address,
                'phone_number' => $owner->contact_number,
                'owner_id'=>$id
            ]);
           

            return $this->sendResponse($owner, 'Owner approved updated successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
