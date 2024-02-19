<?php

namespace App\Http\Controllers\Backend;

use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

    public function SiteSetting()
    {
        $site_setting = SiteSetting::find(1);

        return view('backend.setting.site_update', compact('site_setting'));
    } // End Method

    public function UpdateSiteSetting(Request $request)
    {
        $site_id = $request->id;

        $company_logo_image = $request->file('company_logo');

        if ($company_logo_image) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $company_logo_image->getClientOriginalExtension();
            $image = $manager->read($company_logo_image);
            $image->resize(1500, 386);
            $image->toJpeg(80)->save(base_path('public/upload/logo/' . $name_gen));
            $save_url = 'upload/logo/' . $name_gen;

            // Delete existing image if it exists
            $existing_image = SiteSetting::findOrFail($site_id);
            if ($existing_image->company_logo) {
                if (file_exists(public_path($existing_image->company_logo))) {
                    unlink(public_path($existing_image->company_logo));
                }
            }

            SiteSetting::findOrFail($site_id)->update([
                'company_phone' => $request->company_phone,
                'company_address' => $request->company_address,
                'company_email' => $request->company_email,
                'company_about' => $request->company_about,
                'facebook' => $request->facebook,
                'youtube' => $request->youtube,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
                'company_logo' => $save_url,
            ]);

            $notification = [
                'message' => 'Site Setting Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            SiteSetting::findOrFail($site_id)->update([
                'company_phone' => $request->company_phone,
                'company_address' => $request->company_address,
                'company_email' => $request->company_email,
                'company_about' => $request->company_about,
                'facebook' => $request->facebook,
                'youtube' => $request->youtube,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
            ]);

            $notification = [
                'message' => 'Site Setting Updated without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        }
    } // End Method
}
