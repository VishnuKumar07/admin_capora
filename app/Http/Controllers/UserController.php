<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Education;
use App\Models\SubEducation;
use App\Models\Jobs;
use App\Models\JobCategory;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function Users(Request $request)
    {
        $users = UserDetails::with('users','country','jobcategory','education')->orderBy('id', 'desc')->get();
        $jobcategories = JobCategory::orderby('name', 'asc')->get();
        return view('users', compact('users','jobcategories'));
    }


    public function addUser(Request $request)
    {
        $countries = Country::orderby('name', 'asc')->get();
        $jobcategories = JobCategory::orderby('name', 'asc')->get();
        $educations = Education::orderby('name', 'asc')->get();
        return view('adduser',compact('countries','jobcategories','educations'));
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
            'jobcategory'  => 'required|exists:job_category,id',
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
            'job_category_id'             => $request->jobcategory,
            'education_id'                => $request->education,
            'sub_education_id'            => $request->subeducation,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User created successfully',
            'user_id' => $user->id,
        ]);
    }

    public function deletedUser(Request $request)
    {
        $deletedUsers = User::onlyTrashed()->get();
        return view('deleted-user', compact('deletedUsers'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        $user->update([
            'deleted_by' => null
        ]);
        UserDetails::where('user_id', $id)->onlyTrashed()->restore();
        return redirect()->back()->with('success', 'User restored successfully');
    }


    public function changeuserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required|exists:users,id',
            'new_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $updateuserPassword = User::where('id', $request->user_id)->update([
            'sample_pass' => $request->new_password,
            'password'    => Hash::make($request->new_password),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User password updated successfully',
        ]);
    }

    public function viewProfile(string $encryptedId)
    {
        try {
            $userId = decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404);
        }

        $userDetails = UserDetails::with(['users', 'country', 'jobcategory', 'education'])->where('user_id', $userId)->firstOrFail();
        return view('view-profile', compact('userDetails'));

    }

    public function editProfile(string $encryptedId)
    {
        try {
            $userId = decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404);
        }
        $countries = Country::orderby('name', 'asc')->get();
        $jobcategories = JobCategory::orderby('name', 'asc')->get();
        $educations = Education::orderby('name','asc')->get();
        $userDetails = UserDetails::with(['users', 'country', 'jobcategory', 'education'])->where('user_id', $userId)->firstOrFail();
        // dd($userDetails);
        return view('edit-profile', compact('userDetails','countries','jobcategories','educations'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'           => 'required|exists:users,id',
            'name'         => 'required|string|max:255',
            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('users', 'mobile')->ignore($request->id),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($request->id),
            ],
            'country_code' => 'required|string|max:10',
            'country_id'   => 'required|exists:countries,id',
            'dob'          => 'required|date',
            'age'          => 'required|integer|min:0|max:120',
            'gender'       => 'required|in:Male,Female',
            'passport_no'  => 'required|string|max:50',
            'jobcategory'  => 'required|exists:job_category,id',
            'education_id' => 'required|exists:education,id',
            'subeducation' => 'nullable|exists:sub_education,id',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $updateUser = User::where('id', $request->id)->update([
            'name'            => $request->name,
            'email'           => $request->email,
            'mobile'          => $request->mobile,
            'country_code'    => $request->country_code,
        ]);

        $updateuserDetails = UserDetails::where('user_id', $request->id)->update([
            'current_location_country_id'  => $request->country_id,
            'gender'                       =>  $request->gender,
            'dob'                          =>  $request->dob,
            'age'                          =>  $request->age,
            'passport_no'                  =>  $request->passport_no,
            'job_category_id'              =>  $request->jobcategory,
            'education_id'                 =>  $request->education_id,
            'sub_education_id'             =>  $request->subeducation,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User Details updated successfully',
        ]);
    }

    public function deleteuserAccount(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }
        $user->deleted_by = 'Admin';
        $user->save();
        if ($user->details) {
            $user->details()->delete();
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.',
        ]);

    }

    public function downloadCsv(Request $request): StreamedResponse
    {
        $ids = json_decode($request->input('ids', '[]'), true);
        $selectedColumns = json_decode($request->input('columns', '[]'), true);
        $genderFilter = $request->input('gender');
        $jobcategoryFilter = $request->input('jobcategory');

        if (!is_array($ids)) {
            $ids = [];
        }
        if (!is_array($selectedColumns)) {
            $selectedColumns = [];
        }

        $availableColumns = [
            'id'              => 'ID',
            'name'            => 'Name',
            'email'           => 'Email',
            'username'        => 'Username',
            'mobile'          => 'Mobile',
            'gender'          => 'Gender',
            'age'             => 'Age',
            'dob'             => 'Date of Birth',
            'education'       => 'Education',
            'passport_no'     => 'Passport No',
            'current_country' => 'Current Country',
            'jobcategory'     => 'Job Category',
            'source'          => 'Source',
            'created_at'      => 'Created On',
        ];

        $selectedColumns = array_values(
            array_intersect($selectedColumns, array_keys($availableColumns))
        );

        if (empty($selectedColumns)) {
            $selectedColumns = [
                'id', 'name', 'email', 'username', 'mobile',
                'gender', 'age', 'dob', 'education',
                'passport_no', 'current_country',
                'jobcategory', 'source', 'created_at',
            ];
        }

        if (empty($ids) && !$genderFilter && !$jobcategoryFilter) {
            abort(400, 'No users selected or filters provided.');
        }

        $query = UserDetails::with(['users', 'country', 'jobcategory', 'education']);

        if (!empty($ids)) {
            $ids = array_values(array_filter($ids, function ($v) {
                return is_numeric($v);
            }));
            if (!empty($ids)) {
                $query->whereIn('user_id', $ids);
            }
        }

        if ($genderFilter) {
            $query->where('gender', $genderFilter);
        }

        if ($jobcategoryFilter) {
            if (is_numeric($jobcategoryFilter)) {
                $jobcategoryFilter = (int) $jobcategoryFilter;
                $query->where('job_category_id', $jobcategoryFilter);
            } else {
                $query->where('job_category_id', $jobcategoryFilter);
            }
        }

        $users = $query->get();

        $filename = "selected-users.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $callback = function () use ($users, $availableColumns, $selectedColumns) {
            $file = fopen('php://output', 'w');

            $headerRow = [];
            foreach ($selectedColumns as $col) {
                $headerRow[] = $availableColumns[$col] ?? $col;
            }
            fputcsv($file, $headerRow);

            foreach ($users as $u) {
                $row = [];
                foreach ($selectedColumns as $col) {
                    switch ($col) {
                        case 'id':
                            $row[] = $u->user_id;
                            break;
                        case 'name':
                            $row[] = optional($u->users)->name ?? '';
                            break;
                        case 'email':
                            $row[] = optional($u->users)->email ?? '';
                            break;
                        case 'username':
                            $row[] = optional($u->users)->username ?? '';
                            break;
                        case 'mobile':
                            $row[] = optional($u->users)->mobile ?? '';
                            break;
                        case 'gender':
                            $row[] = $u->gender ?? '';
                            break;
                        case 'age':
                            $row[] = $u->age ?? '';
                            break;
                        case 'dob':
                            $row[] = $u->dob ?? '';
                            break;
                        case 'education':
                            $row[] = optional($u->education)->name ?? '';
                            break;
                        case 'passport_no':
                            $row[] = $u->passport_no ?? '';
                            break;
                        case 'current_country':
                            $row[] = optional($u->country)->name ?? '';
                            break;
                        case 'jobcategory':
                            $row[] = optional($u->jobcategory)->name ?? '';
                            break;
                        case 'source':
                            $row[] = optional($u->users)->source ?? '';
                            break;
                        case 'created_at':
                            $row[] = $u->created_at
                                ? $u->created_at->format('d M Y, h:i A')
                                : '';
                            break;
                        default:
                            $row[] = '';
                            break;
                    }
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
