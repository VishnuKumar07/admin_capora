<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Education;
use App\Models\SubEducation;
use App\Models\Jobs;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function addUser(Request $request)
    {
        $countries = Country::orderby('name', 'asc')->get();
        $jobs = Jobs::orderby('name', 'asc')->get();
        $educations = Education::orderby('name', 'asc')->get();
        return view('adduser',compact('countries','jobs','educations'));
    }

    public function getSubeducation(Request $request)
    {
        $educationId = $request->education_id;
        $subEducations = SubEducation::where('education_id', $educationId)
            ->select('id', 'name', 'name_tamil')
            ->orderBy('name')
            ->get();

        return response()->json($subEducations);
    }

    private function formatUserName($id)
    {
        return 'RSK' . str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'mobile'       => 'required|digits:10|unique:users,mobile',
            'country_code' => 'required|string|max:10',
            'country_id'   => 'required|exists:countries,id',
            'dob'          => 'required|date',
            'age'          => 'required|integer|min:0|max:120',
            'passport_no'  => 'required|string|max:50',
            'apply_for'    => 'required|exists:jobs,id',
            'gender'       => 'required|in:Male,Female',
            'education'    => 'required|exists:education,id',
            'subeducation' => 'nullable|exists:sub_education,id',
            'password'     => 'required|string|min:6',
            'email'        => 'nullable|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name'        => $request->name,
            'country_code' => $request->country_code,
            'email'       => $request->email,
            'mobile'      => $request->mobile,
            'password'    => Hash::make($request->password),
            'sample_pass' => $request->password,
            'source'      => 'Admin',
        ]);

        $username = $this->formatUserName($user->id);

        $user->update(['username' => $username]);

        UserDetails::create([
            'user_id'                     => $user->id,
            'current_location_country_id' => $request->country_id,
            'gender'                      => $request->gender,
            'dob'                         => $request->dob,
            'age'                         => $request->age,
            'passport_no'                 => $request->passport_no,
            'job_id'                      => $request->apply_for,
            'education_id'                => $request->education,
            'sub_education_id'            => $request->subeducation,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User created successfully',
            'user_id' => $user->id,
        ]);
    }
}
