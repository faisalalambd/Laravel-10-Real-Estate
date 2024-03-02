<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenities;

class AmenitiesController extends Controller
{
    public function AllAmenities()
    {
        $amenities = Amenities::latest()->get();

        return view('backend.amenities.all_amenities', compact('amenities'));
    } // End Method

    public function AddAmenity()
    {
        return view('backend.amenities.add_amenity');
    } // End Method

    public function StoreAmenity(Request $request)
    {
        Amenities::insert([
            'amenity_name' => $request->amenity_name,
        ]);

        $notification = [
            'message' => 'Amenity Name Create Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.amenities')->with($notification);
    } // End Method

    public function EditAmenity($id)
    {
        $amenities = Amenities::findOrFail($id);

        return view('backend.amenities.edit_amenity', compact('amenities'));
    } // End Method

    public function UpdateAmenity(Request $request)
    {
        $amenity_id = $request->id;

        Amenities::findOrFail($amenity_id)->update([
            'amenity_name' => $request->amenity_name,
        ]);

        $notification = [
            'message' => 'Amenity Name Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.amenities')->with($notification);
    } // End Method

    public function DeleteAmenity($id)
    {
        Amenities::findOrFail($id)->delete();

        $notification = [
            'message' => 'Amenity Name Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
