<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenities;

class AmenitiesController extends Controller
{
    // Method to display all amenities
    public function AllAmenities()
    {
        // Query the Amenities model to get the latest records
        $amenities = Amenities::latest()->get();

        // Return the view 'backend.amenities.all_amenities' and pass the retrieved amenities to it
        return view('backend.amenities.all_amenities', compact('amenities'));
    } // End Method

    // Method to display the add amenity form
    public function AddAmenity()
    {
        // Return the view named 'backend.amenities.add_amenity'.
        return view('backend.amenities.add_amenity');
    } // End Method

    // Method to store a new amenity
    public function StoreAmenity(Request $request)
    {
        // Insert a new record into the Amenities table with the provided amenity_name from the request
        Amenities::insert([
            'amenity_name' => $request->amenity_name,
        ]);

        // Create a notification message for a successful amenity creation
        $notification = [
            'message' => 'Amenity Name Create Successfully',
            'alert-type' => 'success',
        ];

        // Redirect to the 'all.amenities' route with the notification message
        return redirect()
            ->route('all.amenities')
            ->with($notification);
    } // End Method

    // Method to display the form for editing a specific amenity
    public function EditAmenity($id)
    {
        // Find the Amenity with the given $id or throw a ModelNotFoundException
        $amenities = Amenities::findOrFail($id);

        // Return a view named 'backend.amenities.edit_amenity' and pass the $amenities data to it
        return view('backend.amenities.edit_amenity', compact('amenities'));
    } // End Method

    // Method to update the details of a specific amenity
    public function UpdateAmenity(Request $request)
    {
        // Extract the amenity ID from the request
        $amenity_id = $request->id;

        // Find the Amenity model with the given ID and update its 'amenity_name' field
        Amenities::findOrFail($amenity_id)->update([
            'amenity_name' => $request->amenity_name,
        ]);

        // Define a notification message for a successful update
        $notification = [
            'message' => 'Amenity Name Updated Successfully',
            'alert-type' => 'success',
        ];

        // Redirect to the 'all.amenities' route with the notification message
        return redirect()
            ->route('all.amenities')
            ->with($notification);
    } // End Method

    // Method to delete a specific amenity
    public function DeleteAmenity($id)
    {
        // Find the Amenity with the given $id; throw an exception if not found and delete it.
        Amenities::findOrFail($id)->delete();

        // Prepare a notification message for a successful deletion.
        $notification = [
            'message' => 'Amenity Name Deleted Successfully',
            'alert-type' => 'success',
        ];

        // Redirect back to the previous page with the notification message.
        return redirect()
            ->back()
            ->with($notification);
    } // End Method
}
