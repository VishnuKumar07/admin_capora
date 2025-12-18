<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeJobs = Job::where('status', 'Active')->count();
        $users = User::count();
        $expireJobs = Job::where('status', 'Expired')->count();
        return view('dashboard',compact('activeJobs','users','expireJobs'));
    }
}
