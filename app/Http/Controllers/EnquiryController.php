<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;

class EnquiryController extends Controller
{
    public function contactEnquiry(Request $request)
    {
        $enquiries = ContactForm::all();
        return view('enquiry.contact-enquiry',compact('enquiries'));
    }
}
