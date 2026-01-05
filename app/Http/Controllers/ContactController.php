<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(Request $request)
    {
       $contactDetails = Contact::orderBy('id', 'desc')->get();
       return view('contact.index', compact('contactDetails'));
    }
}
