<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function ContactUsMessage()
    {
        $contact_us_message_data = ContactUs::orderBy('id', 'desc')->get();

        return view('backend.contactUs.contact_us_message', compact('contact_us_message_data'));
    } // End Method

    public function DeleteContactUsMessage($id)
    {
        ContactUs::findOrFail($id)->delete();

        $notification = [
            'message' => 'Contact Us Message Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
