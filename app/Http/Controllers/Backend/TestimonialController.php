<?php

namespace App\Http\Controllers\Backend;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TestimonialController extends Controller
{
    public function AllTestimonial()
    {
        $testimonial = Testimonial::latest()->get();
        return view('backend.testimonial.all_testimonial', compact('testimonial'));
    } // End Method

    public function AddTestimonial()
    {
        return view('backend.testimonial.add_testimonial');
    } // End Method

    public function StoreTestimonial(Request $request)
    {
        $testimonial_image = $request->file('image');

        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $testimonial_image->getClientOriginalExtension();
        $image = $manager->read($testimonial_image);
        $image->resize(100, 100);
        $image->toJpeg(80)->save(base_path('public/upload/testimonial/' . $name_gen));
        $save_url = 'upload/testimonial/' . $name_gen;

        Testimonial::insert([
            'name' => $request->name,
            'designation' => $request->designation,
            'message' => $request->message,
            'image' => $save_url,
        ]);

        $notification = [
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.testimonial')->with($notification);
    } // End Method

    public function EditTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonial.edit_testimonial', compact('testimonial'));
    } // End Method

    public function UpdateTestimonial(Request $request)
    {
        $testimonial_id = $request->id;

        $testimonial_image = $request->file('image');

        if ($testimonial_image) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $testimonial_image->getClientOriginalExtension();
            $image = $manager->read($testimonial_image);
            $image->resize(100, 100);
            $image->toJpeg(80)->save(base_path('public/upload/testimonial/' . $name_gen));
            $save_url = 'upload/testimonial/' . $name_gen;

            // Delete existing image if it exists
            $existing_image = Testimonial::findOrFail($testimonial_id);
            if ($existing_image->image) {
                if (file_exists(public_path($existing_image->image))) {
                    unlink(public_path($existing_image->image));
                }
            }

            Testimonial::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'designation' => $request->designation,
                'message' => $request->message,
                'image' => $save_url,
            ]);

            $notification = [
                'message' => 'Testimonial Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.testimonial')->with($notification);
        } else {
            Testimonial::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'designation' => $request->designation,
                'message' => $request->message,
            ]);

            $notification = [
                'message' => 'Testimonial Updated without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.testimonial')->with($notification);
        }
    } // End Method

    public function DeleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial_image = $testimonial->image;
        unlink($testimonial_image);

        Testimonial::findOrFail($id)->delete();

        $notification = [
            'message' => 'Testimonial Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
