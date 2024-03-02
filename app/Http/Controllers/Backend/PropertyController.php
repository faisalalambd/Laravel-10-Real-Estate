<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\State;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Amenities;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PropertyMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PropertyController extends Controller
{
    public function AllProperty()
    {
        $property = Property::latest()->get();

        return view('backend.property.all_property', compact('property'));
    } // End Method

    public function AddProperty()
    {
        $propertyType = PropertyType::latest()->get();

        $propertyState = State::latest()->get();

        $amenities = Amenities::latest()->get();

        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        return view('backend.property.add_property', compact('propertyType', 'amenities', 'activeAgent', 'propertyState'));
    } // End Method

    public function StoreProperty(Request $request)
    {
        $property_main_thumbnail = $request->file('property_thumbnail');

        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $property_main_thumbnail->getClientOriginalExtension();
        $image = $manager->read($property_main_thumbnail);
        $image->resize(370, 250);
        $image->toJpeg(80)->save(base_path('public/upload/property/thumbnail/' . $name_gen));
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        $amenity = $request->amenities_id;
        $amenities = implode(',', $amenity);
        // dd($amenities);

        $propertyCode = IdGenerator::generate([
            'table' => 'properties',
            'field' => 'property_code',
            'length' => 5,
            'prefix' => 'PC',
        ]);

        $property_id = Property::insertGetId([
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $propertyCode,
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'propertyType_id' => $request->propertyType_id,
            'property_status' => $request->property_status,
            'property_size' => $request->property_size,
            'rooms' => $request->rooms,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'amenities_id' => $amenities,
            'address' => $request->address,
            'state' => $request->state,
            'neighborhood' => $request->neighborhood,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'property_video' => $request->property_video,
            'agent_id' => $request->agent_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'status' => 1,
            'property_thumbnail' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        // Multiple Image Upload From Here
        $multi_images = $request->file('multi_img');

        foreach ($multi_images as $multi_image) {
            $manager = new ImageManager(new Driver());
            $make_name = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();
            $images = $manager->read($multi_image);
            $images->resize(770, 520);
            $images->toJpeg(80)->save(base_path('public/upload/property/multi-images/' . $make_name));
            $save_urls = 'upload/property/multi-images/' . $make_name;

            MultiImage::insert([
                'property_id' => $property_id,
                'photo_name' => $save_urls,
                'created_at' => Carbon::now(),
            ]);
        } // End Foreach

        // End Multiple Image Upload From Here

        // Facilities Add From Here
        $facilities = Count($request->facility_name);

        if ($facilities != null) {
            for ($i = 0; $i < $facilities; $i++) {
                $facilitiesCount = new Facility();
                $facilitiesCount->property_id = $property_id;
                $facilitiesCount->facility_name = $request->facility_name[$i];
                $facilitiesCount->distance = $request->distance[$i];
                $facilitiesCount->save();
            }
        }
        // End Facilities

        $notification = [
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.property')->with($notification);
    } // End Method

    public function EditProperty($id)
    {
        $property = Property::findOrFail($id);

        $propertyState = State::latest()->get();

        $propertyType = PropertyType::latest()->get();

        $amenities = Amenities::latest()->get();

        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        $multiImage = MultiImage::where('property_id', $id)->get();

        $facilities = Facility::where('property_id', $id)->get();

        $amenity_type = $property->amenities_id;
        $property_amenities = explode(',', $amenity_type);

        return view('backend.property.edit_property', compact('property', 'propertyType', 'amenities', 'activeAgent', 'property_amenities', 'multiImage', 'facilities', 'propertyState'));
    } // End Method

    public function UpdateProperty(Request $request)
    {
        $property_id = $request->id;

        $amenity = $request->amenities_id;
        $amenities = implode(',', $amenity);

        Property::findOrFail($property_id)->update([
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'propertyType_id' => $request->propertyType_id,
            'property_status' => $request->property_status,
            'property_size' => $request->property_size,
            'rooms' => $request->rooms,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,
            'amenities_id' => $amenities,
            'address' => $request->address,
            'state' => $request->state,
            'neighborhood' => $request->neighborhood,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'property_video' => $request->property_video,
            'agent_id' => $request->agent_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.property')->with($notification);
    } // End Method

    public function UpdatePropertyThumbnail(Request $request)
    {
        $property_id = $request->id;
        $old_image = $request->old_img;

        $property_main_thumbnail = $request->file('property_thumbnail');

        // Check if Property Main Thumbnail Image is empty
        if (empty($property_main_thumbnail)) {
            $notification = [
                'message' => 'Property Main Thumbnail Image cannot be empty or not provided',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $property_main_thumbnail->getClientOriginalExtension();
        $image = $manager->read($property_main_thumbnail);
        $image->resize(370, 250);
        $image->toJpeg(80)->save(base_path('public/upload/property/thumbnail/' . $name_gen));
        $save_url = 'upload/property/thumbnail/' . $name_gen;

        // If the old image exists, delete it
        if (file_exists($old_image)) {
            unlink($old_image);
        }

        Property::findOrFail($property_id)->update([
            'property_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Property Main Thumbnail Image Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function UpdatePropertyMultiImage(Request $request)
    {
        $multi_images = $request->file('multi_img');

        // Check if $multiImages is empty
        if (empty($multi_images)) {
            $notification = [
                'message' => 'Property Multi Image cannot be empty or not provided',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        foreach ($multi_images as $id => $multi_image) {
            $multi_image_delete = MultiImage::findOrFail($id);
            unlink($multi_image_delete->photo_name);
            $manager = new ImageManager(new Driver());
            $make_name = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();
            $images = $manager->read($multi_image);
            $images->resize(770, 520);
            $images->toJpeg(80)->save(base_path('public/upload/property/multi-images/' . $make_name));
            $save_urls = 'upload/property/multi-images/' . $make_name;

            MultiImage::where('id', $id)->update([
                'photo_name' => $save_urls,
                'updated_at' => Carbon::now(),
            ]);
        } // End Foreach

        $notification = [
            'message' => 'Property Multi Image Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function DeletePropertyMultiImage($id)
    {
        $old_image = MultiImage::findOrFail($id);

        unlink($old_image->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = [
            'message' => 'Property Multi Image Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function StorePropertyMultiImage(Request $request)
    {
        $new_multi_image = $request->image_id;
        $multi_image = $request->file('multi_img');

        // Check if 'multi_img' is empty
        if (empty($multi_image)) {
            $notification = [
                'message' => 'Property Multi Image cannot be empty or not provided',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        $manager = new ImageManager(new Driver());
        $make_name = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();
        $images = $manager->read($multi_image);
        $images->resize(770, 520);
        $images->toJpeg(80)->save(base_path('public/upload/property/multi-images/' . $make_name));
        $save_urls = 'upload/property/multi-images/' . $make_name;

        MultiImage::insert([
            'property_id' => $new_multi_image,
            'photo_name' => $save_urls,
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Property Multi Image Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function UpdatePropertyFacilities(Request $request)
    {
        $propertyId = $request->id;

        if ($request->facility_name == null) {
            return redirect()->back();
        } else {
            Facility::where('property_id', $propertyId)->delete();

            $facilities = count($request->facility_name);

            for ($i = 0; $i < $facilities; $i++) {
                $facilitiesCount = new Facility();
                $facilitiesCount->property_id = $propertyId;
                $facilitiesCount->facility_name = $request->facility_name[$i];
                $facilitiesCount->distance = $request->distance[$i];
                $facilitiesCount->save();
            }
        }

        $notification = [
            'message' => 'Property Facility Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function DeleteProperty($id)
    {
        $property = Property::findOrFail($id);

        unlink($property->property_thumbnail);

        $property->delete();

        $images = MultiImage::where('property_id', $id)->get();

        foreach ($images as $img) {
            unlink($img->photo_name);
        }

        MultiImage::where('property_id', $id)->delete();

        $facilitiesData = Facility::where('property_id', $id)->get();

        foreach ($facilitiesData as $item) {
            $item->delete();
        }

        $notification = [
            'message' => 'Property Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    public function DetailsProperty($id)
    {
        $property = Property::findOrFail($id);

        $propertyType = PropertyType::latest()->get();

        $amenities = Amenities::latest()->get();

        $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();

        $multiImage = MultiImage::where('property_id', $id)->get();

        $facilities = Facility::where('property_id', $id)->get();

        $amenity_type = $property->amenities_id;
        $property_amenities = explode(',', $amenity_type);

        return view('backend.property.details_property', compact('property', 'propertyType', 'amenities', 'activeAgent', 'property_amenities', 'multiImage', 'facilities'));
    } // End Method

    public function InactiveProperty(Request $request)
    {
        $property_id = $request->id;

        Property::findOrFail($property_id)->update([
            'status' => 0,
        ]);

        $notification = [
            'message' => 'Property Inactive Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.property')->with($notification);
    } // End Method

    public function ActiveProperty(Request $request)
    {
        $property_id = $request->id;

        Property::findOrFail($property_id)->update([
            'status' => 1,
        ]);

        $notification = [
            'message' => 'Property Active Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.property')->with($notification);
    } // End Method

    public function AdminPackageHistory()
    {
        $package_history = PackagePlan::latest()->get();
        return view('backend.package.package_history', compact('package_history'));
    } // End Method

    public function PackageInvoice($id)
    {
        $package_history = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('backend.package.package_history_invoice', compact('package_history'))
            ->setPaper('a4')
            ->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('package_invoice.pdf');
    } // End Method

    public function AdminPropertyMessage()
    {
        $user_message = PropertyMessage::latest()->get();
        return view('backend.message.all_message', compact('user_message'));
    } // End Method

    public function AdminMessageDetails($id)
    {
        $user_message = PropertyMessage::latest()->get();

        $message_details = PropertyMessage::findOrFail($id);

        return view('backend.message.message_details', compact('user_message', 'message_details'));
    } // End Method
}
