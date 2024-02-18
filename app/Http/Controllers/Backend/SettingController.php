<?php

namespace App\Http\Controllers\Backend;

use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function SmtpSetting()
    {
        $smtp_setting = SmtpSetting::find(1);
        return view('backend.setting.smtp_update', compact('smtp_setting'));
    } // End Method

    public function UpdateSmtpSetting(Request $request)
    {
        $smtp_id = $request->id;

        SmtpSetting::findOrFail($smtp_id)->update([
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
        ]);

        $notification = [
            'message' => 'SMTP Setting Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
