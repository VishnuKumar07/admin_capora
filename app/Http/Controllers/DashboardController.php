<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeJobs = Job::where('status', 'Active')->count();
        $users = User::count();
        $expireJobs = Job::where('status', 'Expired')->count();
        $todayjobApplicationCount = JobApplication::whereDate('applied_at', today())->count();
        return view('dashboard',compact('activeJobs','users','expireJobs','todayjobApplicationCount'));
    }
}
