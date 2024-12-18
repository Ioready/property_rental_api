<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agent;
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

class AgentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Agent::all(), 200);
    }

    // Store a new property agent
    public function store(Request $request)
    {
        // print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:agents,email_address',
            'password' => 'required|string|min:8|confirmed', 
            'contact_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date' => 'nullable|string',
            'cea_registration_number' => 'required|string',
            'agency_name' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'profile_picture' => 'required',
            'verification_document' => 'required',
            'year_of_experience' => 'required|string',
            'area_of_operation' => 'required|string',
            'terms_and_conditions' => 'required|string',
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        // $agent = Agent::create($validatedData);
        // $response = [
        //     'message'=>'User register successfully.',
        //     'data' => $agent,
        //     'status' => 200,
        // ];
       
        $agent = Agent::create([
            'full_name' => $request->full_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'date' => $request->date,
            'cea_registration_number' => $request->cea_registration_number,
            'agency_name' => $request->agency_name,
            'city' => $request->city,
            'state' => $request->state,
            // 'profile_picture' => $request->profile_picture,
            // 'verification_document' => $request->verification_document,
            'year_of_experience' => $request->year_of_experience,
            'area_of_operation' => $request->area_of_operation,
            'residential' => $request->residential,
            'commercial' => $request->commercial,
            'land' => $request->land,
            'other' => $request->other,
        ]);


        $path = $request->file('profile_picture')->store('images', 'public');
        $path_document = $request->file('verification_document')->store('verification_document', 'public');
        $agent->profile_picture = $path;
        $agent->verification_document = $path_document;
        $agent->save();

        $data[] = [
            'agent'=>$agent,
            'profile_picture'=>Storage::url($agent->profile_picture),
            'verification_document'=>Storage::url($agent->verification_document),
            'status'=>200,
          ];

       
        // return $this->sendResponse($agent, 'Agent register successfully.');

        // return $this->sendResponse($user, 'Agency register successfully.');
        return response()->json($data, 201);
    }

    // Show a single property agent
    public function show($id)
    {
        $agent = Agent::find($id);
        if (!$agent) {
            return response()->json(['message' => 'Agent not found'], 404);
        }
        return response()->json($agent, 200);
    }

    // Update a property agent
    public function update($id, Request $request)
    {
        $agent = Agent::find($id);
        if (!$agent) {
            return response()->json(['message' => 'Agent not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:agents,email_address',
            'password' => 'required|string|min:8|confirmed', 
            'contact_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'date' => 'nullable|string',
            'cea_registration_number' => 'required|string',
            'agency_name' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'year_of_experience' => 'required|string',
            'area_of_operation' => 'required|string',
            'terms_and_conditions' => 'required|string',
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
            


        $agent->update(['full_name' => $request->full_name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'date' => $request->date,
            'cea_registration_number' => $request->cea_registration_number,
            'agency_name' => $request->agency_name,
            'city' => $request->city,
            'state' => $request->state,
            // 'profile_picture' => $request->profile_picture,
            // 'verification_document' => $request->verification_document,
            'year_of_experience' => $request->year_of_experience,
            'area_of_operation' => $request->area_of_operation,
            'residential' => $request->residential,
            'commercial' => $request->commercial,
            'land' => $request->land,
            'other' => $request->other]);
        return response()->json($agent, 200);

    }

    // Delete a property agent
    public function destroy($id)
    {
        $agent = Agent::find($id);
        if (!$agent) {
            return response()->json(['message' => 'Agent not found'], 404);
        }

        $agent->delete();
        return response()->json(['message' => 'Agent deleted successfully'], 200);
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
           
            $agent = Agent::find($id);
            if (!$agent) {
                return response()->json(['error' => 'agent not found'], 404);
            }

            
            $agent->update(['status' => $request->status]);

           

            return $this->sendResponse($agent, 'agent status updated successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }

    public function approveAgent($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'approve_status' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Find the hospital by ID
            $agent = Agent::find($id);
            if (!$agent) {
                return response()->json(['error' => 'agent not found'], 404);
            }

            // Update the hospital status
            $agent->update(['approve_status' => $request->approve_status]);

            // $agent = User::create([
            //     'full_name' => $request->full_name,
            //     'email_address' => $request->email_address,
            //     'password' => Hash::make($request->password),
            //     'contact_number' => $request->contact_number,
            //     'address' => $request->address,
            //     'date' => $request->date,
            //     'cea_registration_number' => $request->cea_registration_number,
            //     'agency_name' => $request->agency_name,
            //     'city' => $request->city,
            //     'state' => $request->state,
            //     // 'profile_picture' => $request->profile_picture,
            //     // 'verification_document' => $request->verification_document,
            //     'year_of_experience' => $request->year_of_experience,
            //     'area_of_operation' => $request->area_of_operation,
            //     'residential' => $request->residential,
            //     'commercial' => $request->commercial,
            //     'land' => $request->land,
            //     'other' => $request->other,
            // ]);
    
            $user = User::create([
                'name' => $agent->full_name,
                'email' => $agent->email_address,
                'password' => $agent->password,
                'role_id' => '3',
                'address' => $agent->address,
                'phone_number' => $agent->contact_number,
                'agent_id'=>$agent->id
                // 'module_permission' => json_encode($request->module_permission),
            ]);
           

            return $this->sendResponse($agent, 'agent approved updated successfully.');
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }

}
