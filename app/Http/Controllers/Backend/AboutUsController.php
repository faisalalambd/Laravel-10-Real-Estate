<?php

namespace App\Http\Controllers\Backend;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AboutUsController extends Controller
{
    public function AllAboutUs()
    {
        $about_us_data = AboutUs::latest()->get();

        return view('backend.aboutUs.all_about_us', compact('about_us_data'));
    } // End Method

    public function EditAboutUs($id)
    {
        $about_us = AboutUs::findOrFail($id);

        return view('backend.aboutUs.edit_about_us', compact('about_us'));
    } // End Method

    public function UpdateAboutUs(Request $request)
    {
        $about_us_id = $request->id;

        $about_us_image = $request->file('image');

        if ($about_us_image) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $about_us_image->getClientOriginalExtension();
            $image = $manager->read($about_us_image);
            $image->resize(440, 570);
            $image->toJpeg(80)->save(base_path('public/upload/about_us/' . $name_gen));
            $save_url = 'upload/about_us/' . $name_gen;

            // Delete existing image if it exists
            $existing_image = AboutUs::findOrFail($about_us_id);
            if ($existing_image->image) {
                if (file_exists(public_path($existing_image->image))) {
                    unlink(public_path($existing_image->image));
                }
            }

            AboutUs::findOrFail($about_us_id)->update([
                'title' => $request->title,
                'long_description' => $request->long_description,
                'years' => $request->years,
                'image' => $save_url,
            ]);

            $notification = [
                'message' => 'About Us Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.about.us')->with($notification);
        } else {
            AboutUs::findOrFail($about_us_id)->update([
                'title' => $request->title,
                'long_description' => $request->long_description,
                'years' => $request->years,
            ]);

            $notification = [
                'message' => 'About Us Updated without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.about.us')->with($notification);
        }
    } // End Method
}
