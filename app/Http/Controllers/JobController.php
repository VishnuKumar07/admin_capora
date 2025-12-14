<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Job;
use App\Models\JobCategory;
use Carbon\Carbon;


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
            'compane_name'        => $request->company_name,
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

}
