<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\JobCategory;

class JobController extends Controller
{
    public function createJob()
    {
        $countries = Country::orderby('name', 'asc')->get();
        $jobcategories = JobCategory::orderby('name', 'asc')->get();
        return view('create-job',compact('countries','jobcategories'));
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

}
