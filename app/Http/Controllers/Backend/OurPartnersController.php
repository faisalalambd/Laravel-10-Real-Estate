<?php

namespace App\Http\Controllers\Backend;

use App\Models\OurPartners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OurPartnersController extends Controller
{
    public function AllOurPartners()
    {
        $our_partners_data = OurPartners::latest()->get();

        return view('backend.ourPartners.all_our_partners', compact('our_partners_data'));
    } // End Method

    public function AddOurPartner()
    {
        return view('backend.ourPartners.add_our_partner');
    }

    public function StoreOurPartner(Request $request)
    {
        $partner_image = $request->file('image');

        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $partner_image->getClientOriginalExtension();
        $image = $manager->read($partner_image);
        $image->resize(180, 70);
        $image->toJpeg(80)->save(base_path('public/upload/our_partner/' . $name_gen));
        $save_url = 'upload/our_partner/' . $name_gen;

        OurPartners::insert([
            'name' => $request->name,
            'image' => $save_url,
        ]);

        $notification = [
            'message' => 'Partner Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.our.partners')->with('notification');
    } // End Method

    public function EditOurPartner($id)
    {
        $our_partner = OurPartners::findOrFail($id);

        return view('backend.ourPartners.edit_our_partner', compact('our_partner'));
    } // End Method

    public function UpdateOurPartner(Request $request)
    {
        $partner_id = $request->id;

        $partner_image = $request->file('image');

        if ($partner_image) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $partner_image->getClientOriginalExtension();
            $image = $manager->read($partner_image);
            $image->resize(180, 70);
            $image->toJpeg(80)->save(base_path('public/upload/our_partner/' . $name_gen));
            $save_url = 'upload/our_partner/' . $name_gen;

            // Delete existing image if it exists
            $existing_image = OurPartners::findOrFail($partner_id);
            if ($existing_image->image) {
                if (file_exists(public_path($existing_image->image))) {
                    unlink(public_path($existing_image->image));
                }
            }

            OurPartners::findOrFail($partner_id)->update([
                'name' => $request->name,
                'image' => $save_url,
            ]);

            $notification = [
                'message' => 'Partner Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.our.partners')->with($notification);
        } else {
            OurPartners::findOrFail($partner_id)->update([
                'name' => $request->name,
            ]);

            $notification = [
                'message' => 'Partner Updated without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.our.partners')->with($notification);
        }
    } // End Method

    public function DeleteOurPartner($id)
    {
        $our_partner = OurPartners::findOrFail($id);
        $partner_image = $our_partner->image;
        unlink($partner_image);

        OurPartners::findOrFail($id)->delete();

        $notification = [
            'message' => 'Partner Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with('notification');
    } //End Method
}
