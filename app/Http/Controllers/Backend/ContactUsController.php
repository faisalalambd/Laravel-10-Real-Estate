<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function ContactUs()
    {
        return view('frontend.contactUs.contact_us');
    } // End Method

    public function StoreContactUsMessage(Request $request)
    {
        ContactUs::insert([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        $notification = [
            'message' => 'Your Message Send Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

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
