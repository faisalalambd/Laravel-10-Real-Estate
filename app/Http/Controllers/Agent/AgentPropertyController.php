<?php

namespace App\Http\Controllers\Agent;

use App\Models\User;
use App\Models\State;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Schedule;
use App\Models\Amenities;
use App\Mail\ScheduleMail;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PropertyMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class AgentPropertyController extends Controller
{
    public function AgentAllProperty()
    {
        $id = Auth::user()->id;
        $property = Property::where('agent_id', $id)->latest()->get();
        return view('agent.property.all_property', compact('property'));
    } // End Method

    public function AgentAddProperty()
    {
        $propertyType = PropertyType::latest()->get();

        $propertyState = State::latest()->get();

        $amenities = Amenities::latest()->get();

        $id = Auth::user()->id;
        $property = User::where('role', 'agent')->where('id', $id)->first();
        $property_count = $property->credit;
        // dd($property_count);

        if ($property_count == 1 || $property_count == 7) {
            return redirect()->route('buy.package');
        } else {
            return view('agent.property.add_property', compact('propertyType', 'amenities', 'propertyState'));
        }
    } // End Method

    public function AgentStoreProperty(Request $request)
    {
        $id = Auth::user()->id;
        $user_id = User::findOrFail($id);
        $user_credit = $user_id->credit;

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
            'agent_id' => Auth::user()->id,
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

        User::where('id', $id)->update([
            'credit' => DB::raw('1 + ' . $user_credit),
        ]);

        $notification = [
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('agent.all.property')->with($notification);
    } // End Method

    public function AgentEditProperty($id)
    {
        $property = Property::findOrFail($id);

        $propertyState = State::latest()->get();

        $propertyType = PropertyType::latest()->get();

        $amenities = Amenities::latest()->get();

        $multiImage = MultiImage::where('property_id', $id)->get();

        $facilities = Facility::where('property_id', $id)->get();

        $amenity_type = $property->amenities_id;
        $property_amenities = explode(',', $amenity_type);

        return view('agent.property.edit_property', compact('property', 'propertyType', 'amenities', 'property_amenities', 'multiImage', 'facilities', 'propertyState'));
    } // End Method

    public function AgentUpdateProperty(Request $request)
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
            'agent_id' => Auth::user()->id,
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

        return redirect()->route('agent.all.property')->with($notification);
    } // End Method

    public function AgentUpdatePropertyThumbnail(Request $request)
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

    public function AgentUpdatePropertyMultiImage(Request $request)
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

    public function AgentDeletePropertyMultiImage($id)
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

    public function AgentStorePropertyMultiImage(Request $request)
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

    public function AgentUpdatePropertyFacilities(Request $request)
    {
        $propertyId = $request->id;

        // Check if the facility_name in the request is null
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

    public function AgentDetailsProperty($id)
    {
        $property = Property::findOrFail($id);

        $propertyType = PropertyType::latest()->get();

        $amenities = Amenities::latest()->get();

        $multiImage = MultiImage::where('property_id', $id)->get();

        $facilities = Facility::where('property_id', $id)->get();

        $amenity_type = $property->amenities_id;
        $property_amenities = explode(',', $amenity_type);

        return view('agent.property.details_property', compact('property', 'propertyType', 'amenities', 'property_amenities', 'multiImage', 'facilities'));
    } // End Method

    public function AgentDeleteProperty($id)
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

        // Redirect back with the notification
        return redirect()->back()->with($notification);
    } // End Method

    public function BuyPackage()
    {
        return view('agent.package.buy_package');
    } // End Method

    public function BuyBusinessPlan()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.business_plan', compact('data'));
    } // End Method

    public function StoreBusinessPlan(Request $request)
    {
        $id = Auth::user()->id;
        $user_id = User::findOrFail($id);
        $user_credit = $user_id->credit;

        PackagePlan::insert([
            'user_id' => $id,
            'package_name' => 'Business',
            'invoice' => 'RS' . mt_rand(10000000, 99999999),
            'package_credits' => '3',
            'package_amount' => '20',
            'created_at' => Carbon::now(),
        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('3 + ' . $user_credit),
        ]);

        $notification = [
            'message' => 'You have purchase Business Package Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('agent.all.property')->with($notification);
    } // End Method

    public function BuyProfessionalPlan()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('agent.package.professional_plan', compact('data'));
    } // End Method

    public function StoreProfessionalPlan(Request $request)
    {
        $id = Auth::user()->id;
        $user_id = User::findOrFail($id);
        $user_credit = $user_id->credit;

        PackagePlan::insert([
            'user_id' => $id,
            'package_name' => 'Professional',
            'invoice' => 'RS' . mt_rand(10000000, 99999999),
            'package_credits' => '10',
            'package_amount' => '50',
            'created_at' => Carbon::now(),
        ]);

        User::where('id', $id)->update([
            'credit' => DB::raw('10 + ' . $user_credit),
        ]);

        $notification = [
            'message' => 'You have purchase Professional Package Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('agent.all.property')->with($notification);
    } // End Method

    public function PackageHistory()
    {
        $id = Auth::user()->id;
        $package_history = PackagePlan::where('user_id', $id)->get();
        return view('agent.package.package_history', compact('package_history'));
    } // End Method

    public function AgentPackageInvoice($id)
    {
        $package_history = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('agent.package.package_history_invoice', compact('package_history'))
            ->setPaper('a4')
            ->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('package_invoice.pdf');
    } // End Method

    public function AgentPropertyMessage()
    {
        $id = Auth::user()->id;
        $user_message = PropertyMessage::where('agent_id', $id)->get();
        return view('agent.message.all_message', compact('user_message'));
    } // End Method

    public function AgentMessageDetails($id)
    {
        $user_id = Auth::user()->id;
        $user_message = PropertyMessage::where('agent_id', $user_id)->get();

        $message_details = PropertyMessage::findOrFail($id);

        return view('agent.message.message_details', compact('user_message', 'message_details'));
    } // End Method

    public function AgentScheduleRequest()
    {
        $id = Auth::user()->id;

        $user_message = Schedule::where('agent_id', $id)->get();

        return view('agent.schedule.schedule_request', compact('user_message'));
    } // End Method

    public function AgentDetailsSchedule($id)
    {
        $schedule_details = Schedule::findOrFail($id);

        return view('agent.schedule.schedule_details', compact('schedule_details'));
    } // End Method

    public function AgentUpdateSchedule(Request $request)
    {
        $schedule_id = $request->id;

        Schedule::findOrFail($schedule_id)->update([
            'status' => '1',
        ]);

        // Start Send Email

        $send_mail = Schedule::findOrFail($schedule_id);

        $data = [
            'tour_date' => $send_mail->tour_date,
            'tour_time' => $send_mail->tour_time,
        ];

        Mail::to($request->email)->send(new ScheduleMail($data));

        // End Send Email

        $notification = [
            'message' => 'You have Confirm Schedule Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('agent.schedule.request')->with($notification);
    } // End Method
}
