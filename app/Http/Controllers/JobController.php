<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobApplication;
use Carbon\Carbon;
use Svg\Tag\Rect;

class JobController extends Controller
{
    public function createJob()
    {
        $countries = Country::orderby('name', 'asc')->get();
        $jobcategories = JobCategory::orderby('name', 'asc')->get();
        return view('jobs.create-job',compact('countries','jobcategories'));
    }

    public function getCurrency(Request $request)
    {
        $country_id = $request->country_id;
        $country = Country::find($country_id);
        if (! $country) {
            return response()->json(['message' => 'Country not found'], 404);
        }
        $currency = $country->currency  ?? null;
        return response()->json(['currency' => $currency]);
    }

    public function storeJob(Request $request)
    {
        $jobEndTimestamp = null;
        if (!empty($request->job_end)) {
            $jobEndTimestamp = Carbon::createFromFormat(
                'Y-m-d g:i A',
                $request->job_end,
                'Asia/Kolkata'
            );
        }

        $lastJob = Job::where('currency', $request->currency)->orderBy('id', 'desc')->first();
        if ($lastJob && preg_match('/_(\d+)$/', $lastJob->job_code, $matches)) {
        $nextNumber = (int) $matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $jobNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $jobCode = 'RSK_' . $request->currency . '_' . $jobNumber;

        $create_job = Job::create([
            'company_name'        => $request->company_name,
            'job_code'            => $jobCode,
            'country_id'          => $request->country,
            'job_category_id'     => $request->job_category,
            'currency'            => $request->currency,
            'salary'              => $request->salary,
            'vacancy'             => $request->vacancy,
            'duty_hours'          => $request->duty_hours,
            'interview_date'      => $request->interview_date,
            'interview_location'  => $request->interview_location,
            'experience_min'      => $request->expMinRaw,
            'experience_max'      => $request->expMax,
            'food_accommodation'  => $request->food,
            'ot_available'        => $request->ot,
            'benefits_available'  => $request->ben,
            'gender'              => $request->gender,
            'notes'               => $request->notes,
            'job_end'             => $jobEndTimestamp,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Job Created successfully',
        ], 201);
    }

    public function activeJobs(Request $request)
    {
        $countries = Country::orderby('name', 'asc')->get();
        $jobcategories = JobCategory::orderby('name', 'asc')->get();
        $activeJobs = Job::with('country','jobCategory')->where('status' , 'Active')->orderby('id', 'desc')->get();
        return view('jobs.active-jobs', compact('activeJobs','countries','jobcategories'));
    }

    public function deleteJob(Request $request)
    {
        $job = Job::findOrFail(decrypt($request->id));
        $job->delete();

        return response()->json([
            'status' => true,
            'message' => 'Job deleted successfully'
        ]);
    }

    public function expireJob(Request $request)
    {
        $job = Job::findOrFail(decrypt($request->id));

        $job->status = 'Expired';
        $job->expire_status = 'Forced';
        $job->job_end = now();
        $job->save();

        return response()->json([
            'status' => true,
            'message' => 'Job marked as expired successfully'
        ]);
    }

    public function updateJob(Request $request)
    {
        $jobEndTimestamp = null;
        if (!empty($request->job_end)) {
            $jobEndTimestamp = Carbon::createFromFormat(
                'Y-m-d g:i A',
                $request->job_end,
                'Asia/Kolkata'
            );
        }
        $jobId = decrypt($request->id);
        $create_job = Job::where('id',$jobId)->update([
            'company_name'        => $request->company_name,
            'country_id'          => $request->country_id,
            'job_category_id'     => $request->job_category_id,
            'currency'            => $request->currency,
            'salary'              => $request->salary,
            'vacancy'             => $request->vacancy,
            'duty_hours'          => $request->duty_hours,
            'interview_date'      => $request->interview_date,
            'interview_location'  => $request->interview_location,
            'experience_min'      => $request->experience_min,
            'experience_max'      => $request->experience_max,
            'food_accommodation'  => $request->food_accommodation,
            'ot_available'        => $request->ot_available,
            'benefits_available'  => $request->benefits_available,
            'gender'              => $request->gender,
            'notes'               => $request->notes,
            'job_end'             => $jobEndTimestamp,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Job Updated successfully',
        ], 200);
    }

    public function expireJobs(Request $request)
    {
        $expiredJobs = Job::with('country','jobCategory')->where('status' , 'Expired')->orderby('id', 'desc')->get();
        return view('jobs.expire-jobs', compact('expiredJobs'));
    }

    public function updateJobStatus(Request $request)
    {
        $jobId = decrypt($request->id);
        $job = Job::findOrFail($jobId);

        $job->update([
            'job_end' => Carbon::createFromFormat(
                'Y-m-d h:i A',
                $request->job_end,
                'Asia/Kolkata'
            ),
            'expire_status' => null,
            'status' => 'Active'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Job activated successfully'
        ]);
    }

    public function AppliedUsers(Request $request)
    {
        $jobApplications = JobApplication::with([
            'user',
            'job.country'
        ])->get();
        return view('jobs.applied-users',compact('jobApplications'));
    }


}
